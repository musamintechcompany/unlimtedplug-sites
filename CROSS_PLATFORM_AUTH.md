# Cross-Platform Authentication Guide

**Technical documentation for Marketplace ↔ Sites SSO integration**

---

## 🎯 Overview

This system enables seamless single sign-on (SSO) between Unlimited Plug Marketplace and Sites platform using API-based authentication with separate databases.

---

## 🏗️ Architecture

### System Design
```
┌─────────────────┐         API Calls          ┌──────────────────┐
│   Marketplace   │ ───────────────────────────> │   Sites Platform │
│  (Port 8000)    │                              │   (Port 8001)    │
│                 │ <─────────────────────────── │                  │
│  Database: MP   │      Token & Response        │  Database: Sites │
└─────────────────┘                              └──────────────────┘
```

### Key Principles
- **Separate Databases**: Each platform maintains its own user database
- **Email as Identifier**: Email is the common identifier across platforms
- **One-Way Flow**: Only Marketplace → Sites (not reverse)
- **Secure Tokens**: One-time use, 5-minute expiry

---

## 🔐 Authentication Flow

### Scenario 1: No Sites Account
```
1. User clicks "Check My Sites" in Marketplace
2. Marketplace calls Sites API: POST /api/check-user
3. Sites responds: { exists: false }
4. Modal appears: "Create Sites Account"
5. User agrees to terms
6. Marketplace calls: POST /api/create-account-from-sites
7. Sites creates account with same password hash
8. Sites generates one-time token
9. Marketplace opens: sites.com/auto-login?token=xxx
10. Sites validates token, logs user in, redirects to dashboard
```

### Scenario 2: Same Password
```
1. User clicks "Check My Sites" in Marketplace
2. Marketplace calls Sites API: POST /api/check-user
3. Sites responds: { exists: true }
4. Marketplace calls: POST /api/verify-password (sends hash)
5. Sites compares hashes: { same_password: true }
6. Marketplace calls: POST /api/generate-login-token
7. Sites generates one-time token
8. Marketplace opens: sites.com/auto-login?token=xxx
9. Sites validates token, logs user in, redirects to dashboard
```

### Scenario 3: Different Password
```
1. User clicks "Check My Sites" in Marketplace
2. Marketplace calls Sites API: POST /api/check-user
3. Sites responds: { exists: true }
4. Marketplace calls: POST /api/verify-password (sends hash)
5. Sites compares hashes: { same_password: false }
6. Modal appears: "Enter Sites Password"
7. User enters Sites password (plain text)
8. Marketplace calls: POST /api/login (sends plain password)
9. Sites validates with Hash::check()
10. Sites generates one-time token
11. Marketplace opens: sites.com/auto-login?token=xxx
12. Sites validates token, logs user in, redirects to dashboard
```

---

## 📡 API Endpoints

### Marketplace API (Receives from Sites)
**None** - One-way integration only

### Sites API (Receives from Marketplace)

#### 1. Check User Exists
```http
POST /api/check-user
Content-Type: application/json

{
  "email": "user@example.com"
}

Response:
{
  "exists": true|false
}
```

#### 2. Verify Password Hash
```http
POST /api/verify-password
Content-Type: application/json

{
  "email": "user@example.com",
  "password_hash": "$2y$12$..."
}

Response:
{
  "same_password": true|false
}
```

#### 3. Create Account from Marketplace
```http
POST /api/create-account-from-marketplace
Content-Type: application/json

{
  "name": "John Doe",
  "email": "user@example.com",
  "password_hash": "$2y$12$...",
  "agreed_to_terms": true,
  "source": "marketplace"
}

Response:
{
  "success": true,
  "token": "abc123..."
}
```

#### 4. Generate Login Token
```http
POST /api/generate-login-token
Content-Type: application/json

{
  "email": "user@example.com"
}

Response:
{
  "token": "abc123..."
}
```

#### 5. Login with Password
```http
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "plain_password"
}

Response:
{
  "success": true,
  "token": "abc123..."
}
```

---

## 🔒 Security Implementation

### Token System
```php
// Generate token
$token = Str::random(64);
Cache::put("auto_login:{$token}", $userId, now()->addMinutes(5));

// Validate token
$userId = Cache::get("auto_login:{$token}");
if ($userId) {
    Cache::forget("auto_login:{$token}"); // Delete after use
    Auth::loginUsingId($userId);
}
```

### Password Handling
```php
// NEVER send plain passwords between platforms
// Only send hashed passwords for comparison

// Marketplace sends hash
$marketplaceHash = auth()->user()->password;

// Sites compares directly
$sitesHash = User::where('email', $email)->first()->password;
$same = ($marketplaceHash === $sitesHash);

// For manual login, send plain password
// Sites validates with Hash::check()
Hash::check($plainPassword, $sitesHash);
```

### CSRF Protection
```javascript
// All API calls include CSRF token
fetch('/api/check-sites-account', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
    },
    credentials: 'same-origin'
})
```

---

## 🛠️ Implementation Files

### Marketplace Files
```
app/Http/Controllers/Api/SitesIntegrationController.php
app/Http/Controllers/AutoLoginController.php
routes/api.php
routes/web.php (auto-login route)
resources/views/user/dashboard.blade.php (button)
resources/views/modals/user/check-sites-account.blade.php
resources/views/modals/user/sites-password-login.blade.php
```

### Sites Files
```
app/Http/Controllers/Api/Auth/CrossPlatformAuthController.php
app/Http/Controllers/AutoLoginController.php
routes/api.php
routes/web.php (auto-login route)
```

---

## 🌐 Environment Detection

### Local Development
```php
$sitesApiUrl = config('app.env') === 'local' 
    ? 'http://localhost:8001/api' 
    : 'https://sites.unlimitedplug.com/api';
```

### Production
```php
$sitesApiUrl = 'https://sites.unlimitedplug.com/api';
```

---

## 🧪 Testing

### Local Testing Setup
1. **Terminal 1**: `cd unlimitedplug && php artisan serve --port=8000`
2. **Terminal 2**: `cd unlimitedplug && npm run dev`
3. **Terminal 3**: `cd unlimitedplug-sites && php artisan serve --port=8001`
4. **Terminal 4**: `cd unlimitedplug-sites && npm run dev`

### Test Scenarios
1. **New User**: Register in Marketplace → Click "Check My Sites" → Create account
2. **Same Password**: Create accounts separately with same password → Test auto-login
3. **Different Password**: Create accounts with different passwords → Test manual login

---

## 🐛 Troubleshooting

### Issue: "Unable to connect to Sites platform"
**Cause**: Sites server not running or wrong URL  
**Solution**: 
- Check Sites server is running on port 8001 (local) or 443 (production)
- Verify `APP_URL` in Sites `.env` matches server port

### Issue: "User not authenticated"
**Cause**: Session not being passed to API  
**Solution**: 
- Ensure `credentials: 'same-origin'` in fetch request
- Check `web` middleware is applied to API routes

### Issue: "Token expired or invalid"
**Cause**: Token older than 5 minutes or already used  
**Solution**: 
- Generate new token
- Check Redis/Cache is working properly

### Issue: Auto-login not working
**Cause**: Password hashes don't match  
**Solution**: 
- This is expected when accounts created separately
- User must enter Sites password manually

---

## 📊 Database Schema

### Marketplace Users Table
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),  -- Bcrypt hash
    email_verified_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Sites Users Table
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),  -- Bcrypt hash
    email_verified_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Note**: User IDs are independent. Same email can have different IDs on each platform.

---

## 🔄 Future Enhancements

### Potential Features
- [ ] Sync profile updates across platforms
- [ ] Unified notification system
- [ ] Shared subscription management
- [ ] Two-way SSO (Sites → Marketplace)
- [ ] OAuth 2.0 implementation
- [ ] Refresh tokens for longer sessions

---

## 📝 Best Practices

### DO ✅
- Always use HTTPS in production
- Validate all API responses
- Log authentication attempts
- Monitor token usage
- Set short token expiry (5 minutes)
- Delete tokens after use
- Use environment detection for URLs

### DON'T ❌
- Never send plain passwords between platforms (except manual login)
- Never store tokens in database
- Never reuse tokens
- Never expose API endpoints publicly without auth
- Never hardcode URLs
- Never skip CSRF protection

---

## 📞 Support

For technical support or questions:
- Email: dev@unlimitedplug.com
- Documentation: [unlimitedplug.com/docs](https://unlimitedplug.com/docs)

---

**Version**: 1.0  
**Last Updated**: 2026-03-03  
**Author**: Unlimited Plug Development Team

# Rental System Documentation

**Multi-tenant rental platform for Shipping Website projects with credit-based payments.**

---

## 🎯 Overview

The rental system allows users to rent Shipping Website projects for a specified duration. Users purchase credits, which are deducted when creating rentals. Expired rentals are automatically suspended via a scheduler command.

### Key Features
- ✅ Credit-based payment system (unlimited balance)
- ✅ Time-based rentals (24 hours to custom duration)
- ✅ Auto-suspension on expiry with scheduler
- ✅ Early renewal support (extends existing expiry)
- ✅ Optional Reseller API with X-API-Key authentication
- ✅ Admin status management (active, on_hold, suspended, banned)
- ✅ Transaction tracking for all credit movements

---

## 👥 Two User Types

### 1. Regular Users
- Rent directly from Sites dashboard
- Navigate to `/rentals/create`
- Select project and duration
- Pay with credits
- Get instant access
- **No API key needed**

### 2. Resellers (Optional)
- Create API key to integrate rentals into external website
- Use X-API-Key header to call `/api/rental/create`
- Programmatically create rentals for their customers
- **API key is optional, only if they want external integration**

---

## 💳 Credit System

### Wallet Model
- **User has one wallet** with unlimited `credits_balance` (decimal 20,2)
- **Auto-created** when user registers
- Tracks total credits available

### Transaction Types
- `purchase` - User buys credits
- `rental` - Credits deducted for rental
- `refund` - Credits refunded
- `adjustment` - Manual admin adjustment

### Transaction Table
```
id (UUID) | user_id | type | amount | description | created_at
```

---

## 🏠 Rental System

### Rental Lifecycle

1. **Create Rental**
   - User selects project and duration
   - Credits deducted from wallet
   - Shipping API called to create tenant
   - Rental record created with expiry date
   - Admin credentials stored (email, password)

2. **Active Rental**
   - User can access Shipping project
   - Admin status: `active`
   - Can renew before expiry

3. **Renewal**
   - User extends rental duration
   - Credits deducted again
   - Expiry date extended (added to current expiry, not from today)
   - If on_hold, status changed back to `active`

4. **Expiry**
   - Scheduler runs hourly: `rentals:suspend-expired`
   - Expired rentals marked as `on_hold`
   - Shipping API called to put admin on_hold
   - User can renew to reactivate

### Rental Table
```
id (UUID) | user_id | rentable_project_id | duration | cost | 
created_at | expires_at | renewed_at | admin_email | admin_password | status
```

### Status Values
- `active` - Rental is valid and accessible
- `on_hold` - Rental expired, can be renewed
- `suspended` - Admin suspended the rental
- `banned` - Permanent suspension

---

## 🔑 Reseller API (Optional)

**Note**: Regular users do NOT need API keys. They rent directly from the dashboard.

API keys are **only for resellers** who want to integrate rentals into external websites.

### Authentication
- Uses `X-API-Key` header
- Format: `sk_` + 32 random characters
- Stored in `api_keys` table

### API Endpoint
```
POST /api/rental/create
Headers: X-API-Key: sk_xxxxx
Body: {
  "project_id": "uuid",
  "duration": 24,
  "customer_email": "customer@example.com"
}
```

### Reseller Workflow
1. Reseller creates API key in dashboard (optional)
2. Reseller calls `/api/rental/create` with X-API-Key
3. Credits deducted from reseller's wallet
4. Rental created for reseller (not customer)
5. Reseller manages rental and provides access to customer

---

## 🗄️ Database Tables

### users
```sql
id | name | email | password | status | theme | created_at | updated_at | deleted_at
```
- `status`: active, on_hold, suspended, banned
- `theme`: light, dark (user preference)

### wallets
```sql
id (UUID) | user_id | credits_balance | created_at | updated_at
```

### transactions
```sql
id (UUID) | user_id | type | amount | description | created_at
```

### rentals
```sql
id (UUID) | user_id | rentable_project_id | duration | cost | 
created_at | expires_at | renewed_at | admin_email | admin_password | status
```

### rentable_projects
```sql
id (UUID) | name | api_url | pricing_24h | pricing_7d | pricing_30d | created_at | updated_at
```

### api_keys
```sql
id (UUID) | user_id | key | status | created_at | updated_at
```

---

## 🔧 Controllers & Services

### RentalService
**Location**: `app/Services/RentalService.php`

**Methods**:
- `createRental($user, $projectId, $duration)` - Create new rental, deduct credits, call Shipping API
- `renewRental($rental, $duration)` - Extend expiry, reactivate if on_hold
- `suspendExpiredRentals()` - Find expired rentals, mark on_hold, call Shipping API

### RentalController
**Location**: `app/Http/Controllers/RentalController.php`

**Routes**:
- `GET /rentals` - List user's rentals
- `GET /rentals/create` - Show create form
- `POST /rentals` - Store new rental
- `GET /rentals/{id}` - Show rental details
- `GET /rentals/{id}/renew` - Show renew form
- `POST /rentals/{id}/renew` - Process renewal

### ApiKeyController
**Location**: `app/Http/Controllers/ApiKeyController.php`

**Routes**:
- `GET /api-keys` - List user's API keys
- `POST /api-keys` - Create new key
- `DELETE /api-keys/{id}` - Delete key
- `PATCH /api-keys/{id}/toggle` - Toggle key status

### RentalApiController
**Location**: `app/Http/Controllers/Api/RentalApiController.php`

**Routes**:
- `POST /api/rental/create` - Reseller API endpoint (X-API-Key auth)

---

## ⏰ Scheduler

### Command
**Location**: `app/Console/Commands/SuspendExpiredRentals.php`

**Signature**: `rentals:suspend-expired`

**Schedule**: Runs hourly (configured in `routes/console.php`)

**Logic**:
1. Find all rentals where `expires_at < now()` and `status = 'active'`
2. Update status to `on_hold`
3. Call Shipping API to put admin on_hold
4. Log count of suspended rentals

### Manual Execution
```bash
php artisan rentals:suspend-expired
```

---

## 🔐 Authorization

### RentalPolicy
- User can only view/renew their own rentals
- Reseller can only view/renew rentals they created

### ApiKeyPolicy
- User can only manage their own API keys

---

## 🚀 Integration with Shipping Website

### Shipping API Endpoints
```
POST /api/tenant/create          # Create tenant admin
POST /api/tenant/hold            # Put admin on_hold (rental expired)
POST /api/tenant/suspend         # Suspend admin (admin action)
POST /api/tenant/activate        # Activate admin (restore from trash)
GET  /api/tenant/check-status    # Verify admin exists
```

### Admin Status Flow
```
create → active → (renew) → active → (expire) → on_hold → (renew) → active
                                              ↓
                                          (suspend) → suspended
```

---

## 📝 Routes

### Web Routes (Authenticated)
```php
Route::middleware('auth')->group(function () {
    Route::resource('rentals', RentalController::class);
    Route::post('rentals/{rental}/renew', [RentalController::class, 'renewStore'])->name('rentals.renew.store');
    Route::resource('api-keys', ApiKeyController::class);
    Route::patch('api-keys/{apiKey}/toggle', [ApiKeyController::class, 'toggle'])->name('api-keys.toggle');
});
```

### API Routes
```php
Route::post('rental/create', [RentalApiController::class, 'create'])->middleware('auth:sanctum');
```

---

## 🎨 UI/UX Features

### Theme Toggle
- Light/dark mode toggle in authenticated app layout
- User preference stored in `users.theme` column
- Applied via HTML class binding
- Persisted across sessions

### Rental Management Pages
- List rentals with status badges
- Create rental form with project selection and duration
- Rental details page with renewal option
- API key management dashboard (optional for resellers)

---

## 🔄 Workflow Examples

### Regular User Renting a Project
1. User navigates to `/rentals/create`
2. Selects project and duration (24h, 7d, 30d, or custom)
3. Clicks "Rent Now"
4. RentalService deducts credits
5. Shipping API creates tenant
6. Rental record created with expiry date
7. User receives admin credentials
8. User can access Shipping project

### User Renewing a Rental
1. User navigates to `/rentals/{id}/renew`
2. Selects new duration
3. Clicks "Renew"
4. RentalService deducts credits again
5. Expiry date extended (added to current expiry)
6. If on_hold, status changed to active
7. Shipping API called to reactivate admin

### Scheduler Suspending Expired Rentals
1. Scheduler runs hourly
2. Finds rentals where `expires_at < now()` and `status = 'active'`
3. Updates status to `on_hold`
4. Calls Shipping API to put admin on_hold
5. User sees "Rental Expired" message
6. User can renew to reactivate

### Reseller Creating Rental via API (Optional)
1. Reseller creates API key in dashboard (optional)
2. Reseller calls `POST /api/rental/create` with X-API-Key header
3. RentalApiController validates key
4. Credits deducted from reseller's wallet
5. Rental created for reseller
6. Reseller receives response with admin credentials
7. Reseller provides access to customer

---

## 🛠️ Setup Checklist

- [x] Create Wallet, Transaction, Rental, RentableProject, ApiKey models
- [x] Create database migrations for all tables
- [x] Create RentalService with business logic
- [x] Create RentalController for user rentals
- [x] Create ApiKeyController for reseller keys
- [x] Create RentalApiController for reseller API
- [x] Create RentalPolicy and ApiKeyPolicy
- [x] Create SuspendExpiredRentals command
- [x] Register scheduler in routes/console.php
- [ ] Add rentable projects to database (via Tinker or seeder)
- [ ] Create rental management views
- [ ] Create API key management views (optional for resellers)
- [ ] Test rental creation flow
- [ ] Test renewal flow
- [ ] Test scheduler command
- [ ] Test reseller API endpoint (optional)

---

## 📊 Next Steps

1. **Seed Rentable Projects**
   - Add available Shipping projects to `rentable_projects` table
   - Set pricing for 24h, 7d, 30d durations

2. **Create Views**
   - Rental list page with status badges
   - Create rental form with project selection
   - Rental details page with renewal option
   - API key management dashboard (optional for resellers)

3. **Testing**
   - Test rental creation with credit deduction
   - Test renewal with expiry extension
   - Test scheduler command
   - Test reseller API with X-API-Key (optional)

4. **Production Deployment**
   - Set up scheduler to run hourly (cron job or queue worker)
   - Configure Shipping API URLs in .env
   - Test cross-platform integration
   - Monitor rental expirations

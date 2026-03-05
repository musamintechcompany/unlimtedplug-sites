# Local Testing Guide - Rental System

## 🚀 Setup Steps

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Seed Test Data
```bash
php artisan db:seed --class=RentalTestSeeder
```

This creates:
- 2 rentable projects (Shipping Pro, Shipping Basic)
- 1 test user (test@example.com / password)
- 1 wallet with 500 credits

### 3. Start Development Server
```bash
php artisan serve
```

Server runs on: `http://localhost:8001`

---

## 🧪 Testing Scenarios

### Scenario 1: User Rents a Project

1. **Login**
   - URL: `http://localhost:8001/login`
   - Email: `test@example.com`
   - Password: `password`

2. **Navigate to Rentals**
   - URL: `http://localhost:8001/rentals`
   - Click "Rent Project" button

3. **Create Rental**
   - Select "Shipping Pro"
   - Select "24 Hours"
   - Verify cost shows: 10 credits
   - Click "Rent Now"

4. **Verify Results**
   - Should redirect to rentals list
   - New rental should appear with status "active"
   - Check database: `SELECT * FROM rentals WHERE user_id = 1;`
   - Check wallet: `SELECT credits_balance FROM wallets WHERE user_id = 1;` (should be 490)

### Scenario 2: User Renews a Rental

1. **View Rental**
   - From rentals list, click "View" on the rental

2. **Renew Rental**
   - Click "Renew Rental" button
   - Select "7 Days"
   - Verify cost shows: 50 credits
   - Click "Renew Now"

3. **Verify Results**
   - Should redirect to rental details
   - Expiry date should be extended (7 days added to current expiry)
   - Wallet balance should be 440 credits (490 - 50)
   - Check database: `SELECT expires_at FROM rentals WHERE id = 'rental_id';`

### Scenario 3: Test Scheduler Command

1. **Create Rental with Short Expiry**
   - Use Tinker to create a rental that expires in 1 minute:
   ```bash
   php artisan tinker
   ```
   ```php
   $user = User::first();
   $project = RentableProject::first();
   $rental = Rental::create([
       'id' => \Illuminate\Support\Str::uuid(),
       'user_id' => $user->id,
       'rentable_project_id' => $project->id,
       'duration' => 1,
       'cost' => 10,
       'expires_at' => now()->subMinutes(5),
       'admin_email' => 'admin@test.com',
       'admin_password' => 'password123',
       'status' => 'active',
   ]);
   exit
   ```

2. **Run Scheduler Command**
   ```bash
   php artisan rentals:suspend-expired
   ```

3. **Verify Results**
   - Command should output: "Suspended X expired rentals."
   - Check database: `SELECT status FROM rentals WHERE id = 'rental_id';` (should be "on_hold")

### Scenario 4: Create API Key (Optional)

1. **Navigate to API Keys**
   - URL: `http://localhost:8001/api-keys`
   - Click "Create Key" button

2. **Generate Key**
   - Click "Generate Key"
   - Copy the displayed key (format: `sk_xxxxx`)

3. **Test API Endpoint**
   ```bash
   curl -X POST http://localhost:8001/api/rental/create \
     -H "X-API-Key: sk_xxxxx" \
     -H "Content-Type: application/json" \
     -d '{
       "project_id": "project_uuid",
       "duration": 24,
       "customer_email": "customer@example.com"
     }'
   ```

---

## 🔍 Database Queries for Testing

### Check Rentals
```sql
SELECT id, user_id, rentable_project_id, duration, cost, expires_at, status 
FROM rentals 
ORDER BY created_at DESC;
```

### Check Wallet Balance
```sql
SELECT user_id, credits_balance FROM wallets;
```

### Check Transactions
```sql
SELECT user_id, type, amount, description, created_at 
FROM transactions 
ORDER BY created_at DESC;
```

### Check API Keys
```sql
SELECT id, user_id, key, status, created_at FROM api_keys;
```

---

## 🐛 Troubleshooting

### Issue: "Rental not found" error
- **Solution**: Verify rental ID in URL matches database

### Issue: "Insufficient credits" error
- **Solution**: Add credits via Tinker:
  ```bash
  php artisan tinker
  $user = User::first();
  $user->wallet->update(['credits_balance' => 1000]);
  exit
  ```

### Issue: Scheduler command not working
- **Solution**: Verify rentals table has expired rentals:
  ```bash
  php artisan tinker
  Rental::where('expires_at', '<', now())->where('status', 'active')->count();
  exit
  ```

### Issue: API endpoint returns 401
- **Solution**: Verify X-API-Key header is correct and key status is "active"

---

## ✅ Testing Checklist

- [ ] User can login
- [ ] User can view rentals list
- [ ] User can create rental (credits deducted)
- [ ] User can view rental details
- [ ] User can renew rental (expiry extended, credits deducted)
- [ ] Scheduler command suspends expired rentals
- [ ] API key can be created
- [ ] API key can be toggled (enable/disable)
- [ ] API key can be deleted
- [ ] API endpoint works with valid X-API-Key
- [ ] API endpoint rejects invalid X-API-Key

---

## 📝 Notes

- Test user has 500 credits initially
- Rentable projects have fixed pricing (24h, 7d, 30d)
- Rentals expire based on `expires_at` timestamp
- Scheduler runs hourly in production (manual in testing)
- API keys are stored as plain text in database (hash in production)
- All timestamps are in UTC


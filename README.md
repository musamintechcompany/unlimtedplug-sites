# Unlimited Plug Sites Platform

**A white-label rental marketplace platform for renting digital projects and templates.**

Website: [unlimitedplug.com](https://unlimitedplug.com)  
Built with Laravel 12 | PHP 8.2+ | MySQL | Redis | Tailwind CSS

---

## 🚀 Features

### User Features
- Browse and search rentable projects
- Rent projects with flexible time-based pricing (24h, 7d, 30d, 365d)
- Credit-based payment system
- Purchase credits in bulk with bonus rewards
- View active rentals and rental history
- User profile with profile photo upload
- Light/dark theme toggle with persistence
- API key management for developers
- Real-time notifications
- Email verification on registration

### Admin Features
- Complete admin panel at `/admin` with role-based access control
- User management (CRUD, ban/unban)
- Project management (CRUD, image uploads, pricing tiers)
- Rental management (view, suspend, activate, cancel)
- Transaction tracking and reporting
- Admin account management with role assignment
- Role and permission management
- Trash/recycle bin for soft-deleted items
- Real-time notifications with mark-as-read functionality
- Settings management
- Beautiful gradient-based UI with dark mode support

### Rental System
- Time-based rentals (hours-based calculation)
- Credits-based payment model
- Auto-suspension on rental expiry
- Renewal functionality
- Rental history tracking
- Integration with Shipping API for tenant management
- Secure platform-to-project API authentication

### Credit System
- Purchase packages: 100, 500, 1000, 5000 credits + Custom amounts
- Bonus credits on larger purchases (10-20% savings)
- Flutterwave payment integration (V3)
- Multi-currency support with auto-detection (USD, GBP, EUR, NGN, GHS, KES, ZAR, CAD, AUD)
- Cloudflare-based country detection for automatic currency selection
- Auto-switching between test/live keys based on environment
- Payment verification and duplicate transaction prevention
- Credit balance tracking
- Transaction history
- Success/failure notifications on dashboard

---

## 📋 Requirements

- PHP 8.2 or higher
- MySQL 8.0+
- Redis (for sessions, cache, queues)
- Composer
- Node.js & NPM
- Laravel 12

---

## 🛠️ Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd unlimitedplug-sites
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Environment
Edit `.env` file:
```env
APP_NAME="Unlimited Plug Sites"
APP_URL=http://localhost:8001

DB_DATABASE=unlimitedplug-sites
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

# Email Configuration (Gmail SMTP)
# Port 587 with TLS or Port 465 with SSL
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Flutterwave Configuration (Auto-switches based on APP_ENV)
FLUTTERWAVE_TEST_PUBLIC_KEY=<your_test_public_key>
FLUTTERWAVE_TEST_SECRET_KEY=<your_test_secret_key>
FLUTTERWAVE_TEST_ENCRYPTION_KEY=<your_test_encryption_key>

FLUTTERWAVE_LIVE_PUBLIC_KEY=<your_live_public_key>
FLUTTERWAVE_LIVE_SECRET_KEY=<your_live_secret_key>
FLUTTERWAVE_LIVE_ENCRYPTION_KEY=<your_live_encryption_key>

# UPS Project Connector API Credentials
UPS_PROJECT_CONNECTOR_API_KEY=<your_api_key>
UPS_PROJECT_CONNECTOR_API_SECRET=<your_api_secret>
```

### 5. Database Setup
```bash
php artisan migrate:fresh
php artisan db:seed --class=PermissionSeeder
```

### 6. Build Assets
```bash
npm run build
```

### 7. Start Services
```bash
# Development
composer run dev

# Or manually:
php artisan serve
php artisan queue:listen
npm run dev
```

---

## 🗂️ Project Structure

```
unlimitedplug-sites/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/              # Admin controllers
│   │   └── ...                 # User controllers
│   ├── Models/                 # Eloquent models
│   ├── Services/               # Business logic
│   └── Middleware/             # Custom middleware
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin panel views
│   │   ├── layouts/            # Layout templates
│   │   └── ...                 # User views
│   ├── css/                    # Stylesheets
│   └── js/                     # JavaScript files
├── routes/
│   ├── admin.php               # Admin routes
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes
└── public/                     # Public assets
```

---

## 🔐 Admin System

### Authentication
- Separate admin guard from user authentication
- Admin login at `/admin/login`
- First admin automatically assigned superadmin role
- 2FA and login verification support
- Admin accounts with soft deletes

### Role-Based Access Control
- Spatie Laravel Permissions integration
- 39 system permissions across all modules
- Custom Role and Permission models with UUID support
- Superadmin role with full access
- Permission checks on all admin routes and views

### Admin Modules
- **Users**: View, edit, ban/unban users, email verification status display
- **Projects**: Full CRUD with image uploads and pricing tiers
- **Rentals**: View, suspend, activate, cancel rentals
- **Transactions**: View transaction history and details
- **Admins**: Manage admin accounts and role assignment
- **Roles**: Create and manage roles with permissions
- **Permissions**: View and manage system permissions
- **Settings**: Platform configuration
- **Trash**: Restore or permanently delete soft-deleted items

---

## 🎨 Admin UI/UX Design

### Design Features
- **Gradient Headers**: Beautiful blue gradient (Blue-600 to Blue-700)
- **Professional Tables**: Modern styling with proper spacing and borders
- **Status Badges**: Color-coded (Green=Active, Red=Inactive)
- **Action Links**: Semantic colors (Blue=View, Green=Edit, Red=Delete)
- **Profile Photos**: With fallback avatars
- **Dark Mode**: Pure black background with proper contrast
- **Empty States**: Professional icons and messages
- **Hover Effects**: Subtle background changes
- **Responsive**: Perfect on all devices

### Index Pages
All admin index pages follow a consistent design pattern:
1. Header with title, subtitle, and action button
2. Success/error alert messages
3. Gradient-header table with data
4. Pagination support
5. Professional empty states

### Notification System
- Right-side sliding notification panel
- Gradient header with "Mark all read" button
- Card-based notification display
- Unread indicators with blue dots
- Relative timestamps
- Professional empty state
- Mark individual or all notifications as read
- Smooth animations and transitions

---

## 📊 Key Systems

### Email Verification System
- 6-digit verification code sent on registration and unverified login
- 15-minute code expiration with automatic cleanup
- Resend verification code functionality (works for both guest and authenticated users)
- Email verification required before dashboard access
- Gmail SMTP integration (Port 465 with SSL or Port 587 with TLS)
- Verification code stored in database with expiry timestamp
- Auto-redirect to verification page on unverified login attempt
- Persistent session management for guest users during verification
- `email_verified_at` timestamp tracking in database
- Admin panel displays user verification status with badges

### Rental System
- Time-based rental pricing (24h, 7d, 30d, 365d)
- Credits deducted on rental creation
- Auto-suspension on expiry via scheduled command
- Renewal functionality with flexible duration input
- Rental history with status tracking (JSON renewal_history field)
- Integration with Shipping API for tenant creation
- Auto-generated unique credentials per rental
- Support for unlimited days/months/years (DATETIME fields)

### Credit System
- 3 credit packages: 100 (no bonus), 500 (+50 bonus, 10% savings), Custom (1000+)
- Custom package with tiered bonuses: 15% for 1000-4999 credits, 20% for 5000+ credits
- Multi-currency support (9 currencies: USD, GBP, EUR, NGN, GHS, KES, ZAR, CAD, AUD)
- Accurate exchange rates: 10 credits = $1 USD equivalent in all currencies
- Price calculation using `price_per_10` (price for 10 credits)
- Auto-currency detection via Cloudflare CF-IPCountry header
- Manual currency selector on credits purchase page
- Dynamic pricing with auto-calculation on currency change
- Flutterwave V3 inline payment integration
- Payment verification with duplicate prevention
- Wallet auto-creation on user registration
- Transaction tracking with project metadata
- Credit balance display on dashboard

### Dashboard
- Welcome section with personalized greeting
- Stats cards: Credits Balance, Total Rentals
- Responsive design (smaller text on mobile)
- Clean, minimal layout

### Navigation
- Desktop navbar with theme toggle and user dropdown
- Mobile sidebar with app name in header, clickable profile footer
- Buy Credits button routes to dedicated purchase page
- Profile image display in all navigation areas
- Active route highlighting
- Notification icon with unread badge
- Notification sidebar slides from right with smooth animations
- Page scrolling disabled when sidebars are open

---

## 🔐 API Authentication

### Platform-to-Project Communication

The platform uses secure authentication when communicating with rental projects:

**Request Headers:**
```
Authorization: Bearer {UPS_PROJECT_CONNECTOR_API_KEY}
X-Platform-Secret: {UPS_PROJECT_CONNECTOR_API_SECRET}
X-User-ID: {authenticated_user_id}
```

**Endpoints:**
- `POST /api/tenant/create` - Create tenant credentials
- `POST /api/tenant/hold/{adminId}` - Suspend tenant
- `POST /api/tenant/activate/{adminId}` - Reactivate tenant
- `GET /api/tenant/status/{adminId}` - Check tenant status

**Project Setup:**
1. Add credentials to project `.env`:
   ```env
   UPS_PROJECT_CONNECTOR_API_KEY=sk_live_51H8vK2Kx9mN4pQ7rS8tU9vW0xY1zA2bC3dE4fG5hI6jK7lM8nO9pQ0rS1tU2vW3-X
   UPS_PROJECT_CONNECTOR_API_SECRET=sk_secret_51H8vK2Kx9mN4pQ7rS8tU9vW0xY1zA2bC3dE4fG5hI6jK7lM8nO9pQ0rS1tU2vW3-X
   ```

2. Create middleware to validate requests (ValidateUpsConnector)

3. Apply middleware to API routes

---

## 📦 Key Packages

- **Laravel Framework 12** - Core framework
- **Laravel Sanctum** - API authentication
- **Spatie Laravel Permission** - Roles & permissions
- **Predis** - Redis client
- **Quill Editor** - Rich text editing
- **Flutterwave V3** - Payment gateway integration

### Key Configuration Files
- **config/services.php** - Flutterwave API keys with environment-based switching
- **config/payment.php** - Currency definitions (9 currencies with price_per_10), country mapping
- **app/Http/Middleware/AutoDetectCurrency.php** - Automatic currency detection middleware
- **resources/views/modals/payment-notifications.blade.php** - Reusable payment success/failure alerts

### Database Tables
- **users** - User accounts with UUID primary keys, profile photos, email verification fields (softDeletes)
- **admins** - Admin accounts with UUID, 2FA columns, soft deletes
- **wallets** - User credit wallets with UUID
- **transactions** - Credit transaction history with UUID, currency, and price tracking
- **rentals** - Rental records with UUID, DATETIME expiry, and JSON renewal_history
- **rentable_projects** - Rentable project catalog with UUID, api_key, api_secret
- **api_keys** - User API keys for developers with UUID
- **roles** - Admin roles with UUID and soft deletes
- **permissions** - System permissions with UUID and soft deletes
- **password_reset_tokens** - Password reset tokens
- **sessions** - User sessions

---

## 🔧 Artisan Commands

```bash
# Cache optimization (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Queue worker
php artisan queue:listen

# Scheduled tasks
php artisan schedule:run

# Seed permissions
php artisan db:seed --class=PermissionSeeder
```

---

## 🔐 Security & Production Rules

**⚠️ CRITICAL: This project is LIVE in production on Coolify**

### Database Safety
- ✅ ALWAYS backup database before migrations
- ✅ ONLY use `php artisan migrate` (never fresh/refresh/rollback)
- ✅ Keep backups for at least 30 days

### Dependency Management
- ✅ NEVER run `composer update` in production
- ✅ ONLY use `composer install --no-dev --optimize-autoloader`
- ✅ ALWAYS commit `composer.lock` to git

### Environment Safety
- ✅ NEVER commit `.env` file
- ✅ NEVER set `APP_DEBUG=true` in production
- ✅ ALWAYS verify environment before running commands

### Git Safety
- ✅ NEVER commit credentials, API keys, or secrets
- ✅ NEVER commit `vendor/` or `node_modules/`
- ✅ ALWAYS review `git status` and `git diff` before committing

### Soft Deletes
- ✅ Users, Admins, Projects, Categories, Rentals, Roles, Permissions have soft deletes
- ✅ Transactions and Wallets are permanent (financial records)
- ✅ API Keys are permanently deleted (security)
- ✅ Trash management system for restoring soft-deleted items

---

## 🚀 Recent Updates

### Email Verification System Overhaul (v2.8)
- Removed LoginRequest class - moved all authentication logic to controller
- Auto-redirect unverified users to verification page on login attempt
- Auto-send verification code when unverified user tries to login
- Fixed email verification routes to work for both guest and authenticated users
- Added `email_verified_at` to User model fillable array
- Implemented persistent session management for guest users during verification
- Fixed resend verification code to work for both registration and login flows
- Gmail SMTP configured with port 465 (SSL) for reliable email delivery
- Added email verification status badges in admin user index and show pages
- Verification status shows green badge for verified, yellow badge for unverified
- Admin user show page displays verification timestamp

### Admin Panel & Notification System (v2.7)
- Complete admin panel with role-based access control
- Beautiful gradient-based UI matching Banking WebApp design
- Professional notification system with right-side sliding panel
- Admin index pages with consistent design pattern
- Trash management with restore and permanent delete
- Permissions management with bulk delete
- Pure black dark mode support
- Full mobile responsiveness

### Platform-to-Project API Authentication (v2.7)
- Implemented secure authentication between Unlimited Plug Sites and rental projects
- Added `api_key` and `api_secret` columns to `rentable_projects` table with indexes
- Created `ValidateUpsConnector` middleware for request validation
- All tenant API endpoints now require authentication headers
- Updated RentalService to send authenticated requests to projects
- Prevents unauthorized access to tenant management endpoints

### Notification Sidebar & Transaction Tracking (v2.5)
- Designed notification cards with modern card-based UI
- Notification sidebar slides from right side with smooth animations
- Page scrolling disabled when sidebars are open
- Relative timestamps (e.g., "2 minutes ago")
- Unread notifications have blue left border and unread badge
- Added `currency` and `price` columns to transactions table
- Payment notifications display actual currency and price paid

### Email Verification System (v2.4)
- Implemented 6-digit email verification code on registration
- 15-minute code expiration with automatic cleanup
- Resend verification code functionality
- Gmail SMTP email integration
- User cannot access dashboard until email is verified

### Currency System Refactor (v2.3)
- Changed from `price_per_100` to `price_per_10` for simpler calculations
- Updated all currency rates based on accurate $1 USD = 10 credits conversion
- All 9 currencies now properly calibrated

### Credit System Optimization (v2.2)
- Reduced packages from 5 to 3 cards for cleaner UI (100, 500, Custom)
- Custom package minimum lowered from 5000 to 1000 credits
- Tiered bonus system: 15% for 1000-4999, 20% for 5000+
- Added CAD and AUD currency support (total 9 currencies)

### Multi-Currency System (v2.1)
- Implemented auto-currency detection using Cloudflare CF-IPCountry header
- Added 7 supported currencies with dynamic pricing
- Currency selector on credits purchase page
- Country-to-currency mapping for automatic selection

### UUID Implementation (v2.0)
- Migrated all primary keys to UUID for better scalability
- Users, wallets, transactions, rentals, projects, API keys now use UUID
- Updated all foreign key relationships

### Payment Integration (v2.0)
- Integrated Flutterwave V3 for credit purchases
- Auto-switching between test/live keys based on APP_ENV
- Payment verification with duplicate transaction prevention
- Project metadata tracking for revenue attribution

---

## 📝 License

Proprietary - All Rights Reserved  
Copyright © 2026 Unlimited Plug

---

## 🤝 Development Team

For development inquiries, contact via [unlimitedplug.com](https://unlimitedplug.com)

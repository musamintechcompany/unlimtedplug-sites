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

### Admin Features (Project Owners)
- Temporary admin panel at `/admin-projects/login` (password: `Osaretine@70`)
- Complete project management (CRUD)
- Project image uploads with drag & drop
- Rich text editor (Quill) for project descriptions
- Set buyable/rentable flags per project
- Multi-currency pricing support
- Project sorting and status management
- Trash/recycle bin for deleted items

### Rental System
- Time-based rentals (hours-based calculation)
- Credits-based payment model
- Auto-suspension on rental expiry
- Renewal functionality
- Rental history tracking
- Integration with Shipping API for tenant management

### Credit System
- Purchase packages: 100, 500, 1000, 5000 credits + Custom amounts
- Bonus credits on larger purchases (10-20% savings)
- Flutterwave payment integration (V3)
- Multi-currency support with auto-detection (USD, GBP, EUR, NGN, GHS, KES, ZAR)
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
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Flutterwave Configuration (Auto-switches based on APP_ENV)
FLUTTERWAVE_TEST_PUBLIC_KEY=<your_test_public_key>
FLUTTERWAVE_TEST_SECRET_KEY=<your_test_secret_key>
FLUTTERWAVE_TEST_ENCRYPTION_KEY=<your_test_encryption_key>

FLUTTERWAVE_LIVE_PUBLIC_KEY=<your_live_public_key>
FLUTTERWAVE_LIVE_SECRET_KEY=<your_live_secret_key>
FLUTTERWAVE_LIVE_ENCRYPTION_KEY=<your_live_encryption_key>
```

### 5. Database Setup
```bash
php artisan migrate:fresh
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
│   ├── Http/Controllers/     # Controllers (Dashboard, Rentals, Credits, etc.)
│   ├── Models/               # Eloquent models (User, Rental, Wallet, etc.)
│   ├── Services/             # Business logic (RentalService)
│   └── Middleware/           # Custom middleware
├── database/
│   └── migrations/           # Database migrations
├── resources/
│   ├── views/                # Blade templates
│   │   ├── dashboard.blade.php
│   │   ├── profile/          # Profile management
│   │   ├── rentals/          # Rental views
│   │   ├── credits/          # Credit purchase
│   │   ├── projects/         # Project management
│   │   └── layouts/          # Layout templates
│   ├── css/                  # Stylesheets
│   └── js/                   # JavaScript files
├── routes/
│   ├── web.php               # Web routes
│   └── console.php           # Scheduled commands
└── public/                   # Public assets
```

---

## 🎨 UI/UX Features

- Responsive hamburger menu with overlay sidebar
- Mobile-optimized navigation with profile dropdown
- Light/dark mode toggle with user preference persistence
- Profile photo upload with live preview
- Drag & drop file uploads
- Rich text editor for project descriptions
- Modal-based credit purchase interface
- Responsive dashboard with stats cards
- Payment success/failure notifications
- Clean, modern design with Tailwind CSS
- Alpine.js for interactive components
- Smooth transitions and animations

---

## 📊 Key Systems

### Email Verification System
- 6-digit verification code sent on registration
- 15-minute code expiration
- Resend code functionality
- Email verification required before dashboard access
- Gmail SMTP integration for sending verification emails
- Verification code stored in database with expiry timestamp
- User model includes `email_verification_code` and `verification_code_expires_at` fields

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
- Responsive price display with auto-sizing for large amounts
- Flutterwave V3 inline payment integration
- Payment verification with duplicate prevention
- Wallet auto-creation on user registration
- Transaction tracking with project metadata
- Credit balance display on dashboard
- Payment notifications in separate reusable component
- Automatic redirect to dashboard after payment
- Future: Admin panel for managing exchange rates and packages

### Dashboard
- Welcome section with personalized greeting
- Stats cards: Credits Balance, Total Rentals
- Responsive design (smaller text on mobile)
- Clean, minimal layout without quick action buttons

### Navigation
- Desktop navbar with theme toggle and user dropdown
- Mobile sidebar with app name in header, clickable profile footer
- Buy Credits button routes to dedicated purchase page
- Profile image display in all navigation areas
- Profile link in mobile dropdown menu
- Active route highlighting
- Notification icon with unread badge in navigation
- Notification sidebar slides from right with smooth animations
- Page scrolling disabled when sidebars are open

### Notification System
- Polymorphic notification model using `uuidMorphs` to work with any model type
- NotificationService with helper methods: paymentSuccess(), paymentFailed(), rentalExpired()
- Notification sidebar with card-based UI design
- Unread notifications have blue left border and unread indicator
- Relative timestamps using diffForHumans()
- Mark individual notifications as read or mark all as read
- Page scrolling disabled when notification sidebar is open
- Notification sidebar only closes via X button
- Empty state with icon when no notifications
- Payment notifications display actual currency and price paid
- Real-time unread badge on notification icon in navigation

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

See `.amazonq/rules/` for detailed safety guidelines.

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
- **config/payment.php** - Currency definitions (9 currencies with price_per_10), country mapping, 2 preset packages
- **app/Http/Middleware/AutoDetectCurrency.php** - Automatic currency detection middleware
- **resources/views/modals/payment-notifications.blade.php** - Reusable payment success/failure alerts

### Database Tables
- **users** - User accounts with UUID primary keys, profile photos, email verification fields (softDeletes)
  - `email_verification_code` - 6-digit verification code
  - `verification_code_expires_at` - Code expiration timestamp
  - `email_verified_at` - Email verification completion timestamp
- **wallets** - User credit wallets with UUID
- **transactions** - Credit transaction history with UUID, currency, and price tracking
  - `currency` - Currency code used for payment (e.g., "NGN", "USD")
  - `price` - Actual amount paid in that currency
- **rentals** - Rental records with UUID, DATETIME expiry, and JSON renewal_history
- **rentable_projects** - Rentable project catalog with UUID
- **api_keys** - User API keys for developers with UUID
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
```

---

## 🚀 Recent Updates

### Notification Sidebar & Transaction Tracking (v2.5)
- Designed notification cards with modern card-based UI
- Each card displays: badge, timestamp, title, message, unread indicator, mark-as-read button
- Notification sidebar slides from right side with smooth animations
- Page scrolling disabled when either hamburger or notification sidebar is open
- Notification sidebar only closes via X button (overlay click also closes for UX)
- Empty state with icon when no notifications exist
- Relative timestamps (e.g., "2 minutes ago")
- Unread notifications have blue left border and unread badge
- Added `currency` and `price` columns to transactions table
- PaymentController now captures and stores actual currency and price paid
- NotificationService displays correct currency symbol and amount in payment notifications
- Example: "You have successfully purchased 100 credits for ₦X,XXX" (instead of hardcoded "$100")
- Transaction model updated with new fillable fields and casts
- Payment verification sends currency and price to backend

### Email Verification System (v2.4)
- Implemented 6-digit email verification code on registration
- 15-minute code expiration with automatic cleanup
- Resend verification code functionality
- Gmail SMTP email integration
- Verification code stored in users table with expiry timestamp
- User cannot access dashboard until email is verified
- Styled verify-email page matching register/login design
- Uses x-auth-card component for consistent UI
- Added VerifyEmailController with show, store, and resend methods
- Created VerificationCodeMail mailable class
- Email template with formatted 6-digit code display
- Routes: `/verify-email` (GET/POST), `/resend-verification-code` (GET)

### Currency System Refactor (v2.3)
- Changed from `price_per_100` to `price_per_10` for simpler calculations
- Updated all currency rates based on accurate $1 USD = 10 credits conversion
- Fixed EUR rate (was 10x too high)
- Calculation formula: `(credits / 10) × price_per_10`
- All 9 currencies now properly calibrated:
  - USD: $1 per 10 credits
  - GBP: £0.80 per 10 credits
  - EUR: €0.90 per 10 credits
  - NGN: ₦1,384 per 10 credits
  - GHS: GH₵10.80 per 10 credits
  - KES: KSh129.20 per 10 credits
  - ZAR: R16.60 per 10 credits
  - CAD: CA$1.40 per 10 credits
  - AUD: A$1.40 per 10 credits

### Credit System Optimization (v2.2)
- Reduced packages from 5 to 3 cards for cleaner UI (100, 500, Custom)
- Custom package minimum lowered from 5000 to 1000 credits
- Tiered bonus system: 15% for 1000-4999, 20% for 5000+
- Added CAD and AUD currency support (total 9 currencies)
- Updated all currency rates based on accurate $0.10 USD conversion
- Auto-calculation on page load for custom package pricing
- Responsive price display with auto-sizing for large amounts (e.g., NGN)
- Payment notifications extracted to reusable component (modals/payment-notifications.blade.php)
- Fixed currency switching bug where custom price didn't update
- Added word-wrap and dynamic font sizing to prevent price overflow

### Multi-Currency System (v2.1)
- Implemented auto-currency detection using Cloudflare CF-IPCountry header
- Added 7 supported currencies with dynamic pricing
- Currency selector on credits purchase page
- Country-to-currency mapping for automatic selection
- Fallback to USD for undetected countries
- Session-based currency persistence
- Real-time price calculation for custom packages

### Custom Credit Packages (v2.1)
- Added custom package option (5th card on purchase page)
- Input field for custom amounts (100-50,000 credits)
- Real-time price calculation based on selected currency
- Min/max validation
- Purple gradient design to distinguish from preset packages

### Payment Flow Improvements (v2.1)
- Automatic redirect to dashboard after payment
- Success message with credit amount and new balance
- Failure and error notifications
- URL parameter-based message system
- Removed modal-based purchase flow
- Dedicated `/credits` purchase page

### UUID Implementation (v2.0)
- Migrated all primary keys to UUID for better scalability
- Users, wallets, transactions, rentals, projects, API keys now use UUID
- Updated all foreign key relationships
- Added HasUuids trait to all models

### Payment Integration (v2.0)
- Integrated Flutterwave V3 for credit purchases
- Auto-switching between test/live keys based on APP_ENV
- Payment verification with duplicate transaction prevention
- Project metadata tracking for revenue attribution
- 4 credit packages: 100 ($10), 500 ($45), 1000 ($85), 5000 ($400)

### Rental System Enhancements (v2.0)
- Changed TIMESTAMP to DATETIME for rental dates (supports year 9999)
- Added renewal_history JSON field for tracking all renewals
- Fixed pricing calculation to use pricing tiers instead of hourly rates
- Support for 10,000+ day rentals
- Flexible renewal duration input (days/weeks/months/years)

### Code Organization (v2.0)
- Consolidated all JavaScript into app.js with detailed comments
- Removed inline scripts from blade templates
- Added meta tags for user data and Flutterwave config
- Improved code maintainability and debugging

### Profile System
- Added `profile_photo_path` column to users table
- Profile photo upload with live preview on profile page
- Profile image display in navigation (mobile & sidebar)
- Profile image fallback to user initials
- Added `profile_photo_path` to User model fillable array

### Dashboard Redesign
- Removed border lines for cleaner appearance
- Removed Account Status card
- Removed Quick Actions section (moved Buy Credits to sidebar)
- Smaller text on mobile view (heading: text-base, paragraph: text-xs)
- Responsive welcome section

### Navigation Updates
- Added Buy Credits button to sidebar
- Profile image display in mobile avatar
- Profile image display in sidebar footer
- User name with border styling in sidebar footer
- Removed email from sidebar (visible on profile page only)

### UI/UX Improvements
- Changed authenticated pages background from gray-100 to gray-50 (lighter)
- Mobile-responsive profile photo upload
- Live image preview during upload
- Improved sidebar layout with app name in header, profile in footer

### Flutterwave Integration
- V3 inline checkout integration
- Auto-switching between test/live keys based on APP_ENV
- Multi-currency payment support
- Payment verification API integration
- Duplicate transaction prevention
- Project metadata tracking for revenue attribution

---

## 📝 License

Proprietary - All Rights Reserved  
Copyright © 2026 Unlimited Plug

---

## 🤝 Development Team

For development inquiries, contact via [unlimitedplug.com](https://unlimitedplug.com)

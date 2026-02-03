# Laravel SaaS Starter Kit v1.0

A modern, production-ready Laravel SaaS starter kit with authentication, dark mode, and responsive design.

## Features

### Authentication
- User registration and login
- Password reset functionality
- Email verification (disabled by default)
- Profile management (update info, change password, delete account)

### Design System
- System-preference dark mode (automatic detection)
- Consistent color palette:
  - Background: `#0a0a0a` (dark) / `#FDFDFC` (light)
  - Cards: `#161615` (dark) / `#ffffff` (light)
  - Primary text: `#EDEDEC` (dark) / `#18181b` (light)
  - Secondary text: `#A1A09A` (dark) / `#706f6c` (light)
  - Borders: `#3E3E3A` (dark) / `#e3e3e0` (light)
- Fully responsive mobile and desktop layouts

### UI Components
- Modern welcome page with phone mockup showcase
- Clean authentication pages (login, register, forgot password)
- Dashboard with navigation
- Profile management pages
- Mobile-friendly navigation with slide-out sidebar
- Dropdown menus and modals

### Technical Stack
- Laravel 12.x
- Laravel Breeze (authentication scaffolding)
- Blade templates
- Tailwind CSS v4
- SQLite database (default)

## Installation

### Requirements
- PHP 8.2 or higher
- Composer
- Node.js & NPM

### Setup

1. Extract the downloaded ZIP file to your desired location:
```bash
cd laravel-saas-starter-kit-v1.0
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create environment file:
```bash
copy .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run database migrations:
```bash
php artisan migrate
```

7. Build assets:
```bash
npm run dev
```

8. Start the development server:
```bash
php artisan serve
```

Visit `http://localhost:8000` or `http://127.0.0.1:8000` to see your application.

## Configuration

### Email Verification
Email verification is disabled by default. To enable it:

1. Open `app/Models/User.php`
2. Uncomment the `MustVerifyEmail` interface:
```php
class User extends Authenticatable implements MustVerifyEmail
```

### Database
The default database is SQLite. To use MySQL or PostgreSQL, update your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Mail Configuration
Configure your mail settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Project Structure

```
resources/views/
├── auth/                    # Authentication pages
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password.blade.php
│   ├── reset-password.blade.php
│   └── verify-email.blade.php
├── layouts/                 # Layout templates
│   ├── app.blade.php       # Authenticated layout
│   ├── guest.blade.php     # Guest layout
│   └── navigation.blade.php
├── profile/                 # Profile management
│   ├── edit.blade.php
│   └── partials/
├── components/              # Reusable components
├── dashboard.blade.php      # Dashboard page
└── welcome.blade.php        # Landing page
```

## Dark Mode

Dark mode automatically follows the user's system preferences. No manual toggle required.

The implementation uses:
```javascript
if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.documentElement.classList.add('dark')
}
```

## Customization

### Colors
Update the color palette in your Blade templates by replacing the hex values:
- `#0a0a0a` - Dark background
- `#161615` - Dark cards
- `#EDEDEC` - Dark primary text
- `#A1A09A` - Dark secondary text
- `#3E3E3A` - Dark borders

### Branding
- Update `APP_NAME` in `.env`
- Replace logo in `resources/views/components/application-logo.blade.php`
- Customize welcome page content in `resources/views/welcome.blade.php`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

Built with:
- [Laravel](https://laravel.com)
- [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)
- [Tailwind CSS](https://tailwindcss.com)

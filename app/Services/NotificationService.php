<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;

class NotificationService
{
    public static function create(Model $notifiable, string $type, string $title, string $message, array $data = []): Notification
    {
        return Notification::create([
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function paymentSuccess(Model $notifiable, int $credits, float $price, string $currency, int $totalCredits = null): Notification
    {
        $currencyInfo = config('payment.currencies')[$currency] ?? ['symbol' => '$'];
        $symbol = $currencyInfo['symbol'];
        $total = $totalCredits ?? $credits;
        $bonus = $total - $credits;
        
        $data = ['credits' => $credits, 'total' => $total, 'price' => $price, 'currency' => $currency];
        if ($bonus > 0) {
            $data['bonus'] = $bonus;
        }
        
        return self::create(
            $notifiable,
            'payment_success',
            'Payment Successful',
            "You have successfully purchased {$credits} credits for {$symbol}{$price}",
            $data
        );
    }

    public static function paymentFailed(Model $notifiable, int $credits, string $reason): Notification
    {
        return self::create(
            $notifiable,
            'payment_failed',
            'Payment Failed',
            "Your payment for {$credits} credits failed: {$reason}",
            ['credits' => $credits, 'reason' => $reason]
        );
    }

    public static function rentalExpired(Model $notifiable, string $projectName): Notification
    {
        return self::create(
            $notifiable,
            'rental_expired',
            'Rental Expired',
            "Your rental for '{$projectName}' has expired",
            ['project_name' => $projectName]
        );
    }

    public static function rentalCreated(Model $notifiable, string $projectName, int $credits, int $durationValue, string $durationType, $rentalId = null): Notification
    {
        $durationLabel = match($durationType) {
            'daily' => 'Day(s)',
            'weekly' => 'Week(s)',
            'monthly' => 'Month(s)',
            'yearly' => 'Year(s)',
            default => $durationType
        };
        
        return self::create(
            $notifiable,
            'rental_created',
            'Rental Created',
            "You have rented '{$projectName}' for {$durationValue} {$durationLabel} ({$credits} credits)",
            ['project_name' => $projectName, 'credits' => $credits, 'duration_value' => $durationValue, 'duration_type' => $durationType]
        );
    }

    public static function rentalRenewed(Model $notifiable, string $projectName, int $credits, int $quantity, string $durationType, $rentalId = null): Notification
    {
        $durationLabel = match($durationType) {
            'daily' => 'Day(s)',
            'weekly' => 'Week(s)',
            'monthly' => 'Month(s)',
            'yearly' => 'Year(s)',
            default => $durationType
        };
        
        return self::create(
            $notifiable,
            'rental_renewed',
            'Rental Renewed',
            "You have renewed '{$projectName}' for {$quantity} {$durationLabel} ({$credits} credits)",
            ['project_name' => $projectName, 'credits' => $credits, 'quantity' => $quantity, 'duration_type' => $durationType]
        );
    }

    public static function rentalSuspended(Model $notifiable, string $projectName, $rentalId = null): Notification
    {
        return self::create(
            $notifiable,
            'rental_suspended',
            'Rental Suspended',
            "Your rental for '{$projectName}' has been suspended due to expiry",
            ['project_name' => $projectName]
        );
    }

    // ── Admin Notifications ──

    private static function notifyAdmins(string $type, string $title, string $message, array $data = [], ?string $permission = null): void
    {
        try {
            $query = Admin::where('status', 'active');
            $admins = $query->get();

            foreach ($admins as $admin) {
                if ($permission && !$admin->hasPermissionTo($permission, 'admin')) {
                    continue;
                }
                self::create($admin, $type, $title, $message, $data);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to notify admins: ' . $e->getMessage());
        }
    }

    public static function adminNewUser(Model $user): void
    {
        self::notifyAdmins(
            'admin_new_user',
            'New User Registered',
            "{$user->name} ({$user->email}) has registered on the platform.",
            ['user_id' => $user->id, 'user_name' => $user->name, 'user_email' => $user->email],
            'view-users'
        );
    }

    public static function adminNewRental(Model $user, string $projectName, int $credits, int $durationValue, string $durationType): void
    {
        $durationLabel = match($durationType) {
            'daily' => 'Day(s)',
            'weekly' => 'Week(s)',
            'monthly' => 'Month(s)',
            'yearly' => 'Year(s)',
            default => $durationType
        };

        self::notifyAdmins(
            'admin_new_rental',
            'New Rental',
            "{$user->name} rented '{$projectName}' for {$durationValue} {$durationLabel} ({$credits} credits).",
            ['user_id' => $user->id, 'user_name' => $user->name, 'project_name' => $projectName, 'credits' => $credits, 'duration_value' => $durationValue, 'duration_type' => $durationType],
            'view-rentals'
        );
    }

    public static function adminRentalRenewed(Model $user, string $projectName, int $credits, int $quantity, string $durationType): void
    {
        $durationLabel = match($durationType) {
            'daily' => 'Day(s)',
            'weekly' => 'Week(s)',
            'monthly' => 'Month(s)',
            'yearly' => 'Year(s)',
            default => $durationType
        };

        self::notifyAdmins(
            'admin_rental_renewed',
            'Rental Renewed',
            "{$user->name} renewed '{$projectName}' for {$quantity} {$durationLabel} ({$credits} credits).",
            ['user_id' => $user->id, 'user_name' => $user->name, 'project_name' => $projectName, 'credits' => $credits, 'quantity' => $quantity, 'duration_type' => $durationType],
            'view-rentals'
        );
    }

    public static function adminPaymentReceived(Model $user, int $credits, float $price, string $currency): void
    {
        $currencyInfo = config('payment.currencies')[$currency] ?? ['symbol' => '$'];
        $symbol = $currencyInfo['symbol'];

        self::notifyAdmins(
            'admin_payment_received',
            'Payment Received',
            "{$user->name} purchased {$credits} credits for {$symbol}{$price} {$currency}.",
            ['user_id' => $user->id, 'user_name' => $user->name, 'credits' => $credits, 'price' => $price, 'currency' => $currency],
            'view-transactions'
        );
    }

    public static function adminRentalExpired(Model $user, string $projectName): void
    {
        self::notifyAdmins(
            'admin_rental_expired',
            'Rental Expired',
            "{$user->name}'s rental for '{$projectName}' has expired and been suspended.",
            ['user_id' => $user->id, 'user_name' => $user->name, 'project_name' => $projectName],
            'view-rentals'
        );
    }
}

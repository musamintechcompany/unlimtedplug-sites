<?php

namespace App\Services;

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

    public static function paymentSuccess(Model $notifiable, int $credits, float $price, string $currency): Notification
    {
        $currencyInfo = config('payment.currencies')[$currency] ?? ['symbol' => '$'];
        $symbol = $currencyInfo['symbol'];
        
        return self::create(
            $notifiable,
            'payment_success',
            'Payment Successful',
            "You have successfully purchased {$credits} credits for {$symbol}{$price}",
            ['credits' => $credits, 'price' => $price, 'currency' => $currency]
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
}

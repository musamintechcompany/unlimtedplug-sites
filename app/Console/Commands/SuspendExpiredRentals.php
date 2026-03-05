<?php

namespace App\Console\Commands;

use App\Services\RentalService;
use Illuminate\Console\Command;

class SuspendExpiredRentals extends Command
{
    protected $signature = 'rentals:suspend-expired';
    protected $description = 'Suspend rentals that have expired';

    public function handle(RentalService $rentalService)
    {
        $count = $rentalService->suspendExpiredRentals();
        $this->info("Suspended {$count} expired rentals.");
    }
}

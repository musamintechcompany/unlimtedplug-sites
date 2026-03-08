<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

if (config('app.env') === 'local') {
    Schedule::command('rentals:suspend-expired')->everySecond();
} else {
    Schedule::command('rentals:suspend-expired')->everyMinute();
}

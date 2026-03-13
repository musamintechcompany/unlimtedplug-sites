<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::firstOrCreate(['key' => 'admin_login_prefix'], ['value' => 'admin']);
        Setting::firstOrCreate(['key' => 'logo_display'], ['value' => 'name_only']);
    }
}

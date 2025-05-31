<?php

namespace Database\Seeders;

use App\Models\SystemSettings;
use Illuminate\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{
    public function run()
    {
        SystemSettings::create([
            'start_date' => now()->addDays(7), // Start 7 days from today
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'max_per_hour' => 5,
        ]);
    }
}

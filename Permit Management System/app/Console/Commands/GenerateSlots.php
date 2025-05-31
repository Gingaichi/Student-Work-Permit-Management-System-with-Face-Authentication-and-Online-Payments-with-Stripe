<?php

use Illuminate\Console\Command;
use App\Models\AvailableSlot;
use App\Models\SystemSettings;
use Carbon\Carbon;

class GenerateSlots extends Command
{
    protected $signature = 'generate:slots';
    protected $description = 'Generate appointment slots starting from a specific date';

    public function handle()
    {
        $settings = SystemSettings::first();
        if (!$settings) {
            $this->error('No system settings found.');
            return;
        }

        $startDate = Carbon::parse($settings->start_date); // Get start date
        $startTime = Carbon::parse($settings->start_time);
        $endTime = Carbon::parse($settings->end_time);
        $maxPerHour = $settings->max_per_hour;

        $numDays = 30; // Generate slots for the next 30 days

        for ($i = 0; $i < $numDays; $i++) {
            $currentDay = $startDate->copy()->addDays($i);

            // Skip weekends if collection is Mon-Fri
            if ($currentDay->isWeekend()) {
                continue;
            }

            $currentHour = $startTime->copy();

            while ($currentHour->lessThan($endTime)) {
                for ($j = 0; $j < $maxPerHour; $j++) {
                    AvailableSlot::firstOrCreate([
                        'date' => $currentDay->toDateString(),
                        'slot_time' => $currentHour->toTimeString(),
                        'is_booked' => false,
                    ]);
                }

                // Move to the next hour
                $currentHour->addHour();
            }
        }

        $this->info('Slots generated successfully!');
    }
    
}

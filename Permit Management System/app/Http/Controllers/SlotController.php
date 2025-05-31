<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailableSlot;
use App\Models\SystemSettings;
use Carbon\Carbon;

class SlotController extends Controller
{
    public function generateSlots()
{
    $settings = SystemSettings::first();
    if (!$settings) {
        return response()->json(['message' => 'No system settings found.'], 400);
    }

    // Start from tomorrow
    $startDate = Carbon::tomorrow();
    $startTime = Carbon::parse($settings->start_time);
    $endTime = Carbon::parse($settings->end_time);
    $maxPerHour = $settings->max_per_hour;

    $numDays = 30; // Generate slots for the next 30 days

    for ($i = 0; $i < $numDays; $i++) {
        $currentDay = $startDate->copy()->addDays($i);

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

            $currentHour->addHour();
        }
    }

    return response()->json(['message' => 'Slots generated successfully!'], 200);
}


}


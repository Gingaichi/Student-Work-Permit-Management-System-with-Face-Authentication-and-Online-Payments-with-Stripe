<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\GenerateSlots;  // Add this line

class Kernel extends ConsoleKernel
{
    protected $commands = [
        GenerateSlots::class,  // Register the command here
    ];

    protected function schedule(Schedule $schedule)
{
    $schedule->command('generate:slots')->dailyAt('00:01');
}


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Run stock refresh daily at 3:00 AM
        $schedule->command('stock:refresh')
            ->dailyAt('03:00')
            ->timezone('Europe/Amsterdam')
            ->emailOutputOnFailure(config('mail.from.address'));
        
        // Check freshness and send alerts twice daily
        $schedule->command('freshness:check --notify')
            ->twiceDaily(6, 14) // 6:00 AM and 2:00 PM
            ->timezone('Europe/Amsterdam')
            ->emailOutputOnFailure(config('mail.from.address'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

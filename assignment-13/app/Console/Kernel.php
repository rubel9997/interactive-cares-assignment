<?php

namespace App\Console;

use App\Jobs\ProcessVaccinatedUsersJob;
use App\Jobs\ResetVaccinatedCenterLimitJob;
use App\Jobs\ScheduleNotVaccinateUsersJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->job(new ScheduleNotVaccinateUsersJob)
            ->dailyAt('19:00')
            ->days([
                Schedule::SUNDAY,
                Schedule::MONDAY,
                Schedule::TUESDAY,
                Schedule::WEDNESDAY,
                Schedule::THURSDAY
            ]);

        $schedule->job(new ProcessVaccinatedUsersJob)->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

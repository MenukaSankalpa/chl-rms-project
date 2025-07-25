<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        //backup schedule
        $schedule->command('backup:clean')->monthly()->appendOutputTo(storage_path('logs/backup.log'));
        $schedule->command('backup:run --only-db')->dailyAt('02:00')->appendOutputTo(storage_path('logs/backup.log'));
        $schedule->command('backup:run --only-db')->dailyAt('06:00')->appendOutputTo(storage_path('logs/backup.log'));
        $schedule->command('backup:run --only-db')->dailyAt('10:00')->appendOutputTo(storage_path('logs/backup.log'));
        $schedule->command('backup:run --only-db')->dailyAt('14:00')->appendOutputTo(storage_path('logs/backup.log'));
        $schedule->command('backup:run --only-db')->dailyAt('18:00')->appendOutputTo(storage_path('logs/backup.log'));
        $schedule->command('backup:run --only-db')->dailyAt('22:00')->appendOutputTo(storage_path('logs/backup.log'));
        $schedule->command('backup:run --only-db')->daily()->appendOutputTo(storage_path('logs/backup.log'));
        $schedule->command('backup:run --only-db')->monthly()->appendOutputTo(storage_path('logs/backup.log'));

        //cleanup schedule
        $schedule->command('trim:audit')->monthly()->appendOutputTo(storage_path('logs/cleanup.log'));
        $schedule->command('trim:changelog')->monthly()->appendOutputTo(storage_path('logs/cleanup.log'));
        $schedule->command('trim:tempcontainers')->daily()->appendOutputTo(storage_path('logs/cleanup.log'));
        $schedule->command('trim:tempplugon')->daily()->appendOutputTo(storage_path('logs/cleanup.log'));
        $schedule->command('trim:uploads')->daily()->appendOutputTo(storage_path('logs/cleanup.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

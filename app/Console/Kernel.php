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
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('telescope:prune --hours=48')->daily();

        if (app()->environment('production')) {
            $schedule->command('sync:products')->everyTenMinutes();

            $schedule->command('sync:products', ['--unavailable'])->dailyAt('03:00');

            $schedule->command('horizon:snapshot')->everyFiveMinutes();

            $schedule->command('backup:clean')->daily()->at('03:00');
            $schedule->command('backup:run')->daily()->at('03:30');
            $schedule->command('backup:run --only-db --disable-notifications')->hourly();

            $schedule->command('elementa:sync-all-products-from-all-categories')->weeklyOn(1, '3:00');
        }
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

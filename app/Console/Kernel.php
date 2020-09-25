<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Auth;
use App\Notifications\InvoicePaid;
use Notification;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\RfpEcheance',
        'App\Console\Commands\NewYear',
        'App\Console\Commands\WeekEnd',
        'App\Console\Commands\Birthday',
        'App\Console\Commands\CleanNotifications',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        //Weekend
            $schedule->call('command:weekEnd')->weekly()->fridays()->at('8:00')->timezone('Africa/Algiers');
        //New year
        $schedule->call('command:newYear')->yearly()->timezone('Africa/Algiers');
        ///RFPS date echeance :
        $schedule->command('hour:update')->dailyAt('18:33')->timezone('Africa/Algiers');

        //Supprimer les notification qui date plus qu'un mois
        $schedule->call('Notification:cleanDB')->monthly()->timezone('Africa/Algiers');
        //Members Birthdays
        $schedule->call('command:birthday')->dailyAt('00:00')->timezone('Africa/Algiers');
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

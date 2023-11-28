<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Encounter;

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
    // Schedule the task to run every hour
 
    $schedule->call(function () {
        $encController = new \App\Http\Controllers\EncounterController();
        $encController->updateEncounterStatus();
    })->hourly()->cron('0 * * * *'); 


    $schedule->call(function () {
        $srsController = new \App\Http\Controllers\SRSController();
        $srsController->srsData();
    })->dailyAt('18:00')->cron('0 0 * * *');
    


}

   //   */30 * * * * cd /var/www/html/ju-sis && php artisan schedule:run >> /dev/null 2>&1
   
  //   0 * * * * cd /var/www/html/ju-sis && php artisan schedule:run >> /dev/null 2>&1  #hourly
 //    0 0 * * * cd /var/www/html/ju-sis && php artisan schedule:run >> /dev/null 2>&1  #daily mid night



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

<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;
use App\Models\Miller;
use Carbon\Carbon;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {

            $todate = Carbon::now()->toDateTimeString();  // Today date
            $year = Carbon::now()->year;  // get current year
            $lastDayOfDeposite = Carbon::today()->setDate($year,6,30); //make last deposite date

            //$millers = Miller::sortable()
            //->whereDate("license_deposit_date",'>', $lastDayOfDeposite)
            //->Where("license_no", '!=', null)
            //->Where("license_type_id", '=', "2")->get();

            $millers = Miller::sortable()
            ->join('license_fee', 'miller.license_fee_id', '=', 'license_fee.id')
            ->whereDate("miller.license_deposit_date",'>', $lastDayOfDeposite)
            ->Where("miller.license_no", '!=', null)
            ->Where("license_fee.license_type_id", '=', "2");

            foreach ($millers as $miller)
            {
                $miller->miller_status = 'inactive';
                $miller->save();
            }

        })->yearly();
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

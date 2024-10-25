<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Appointment;

use App\Models\ParkPrice;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SMSNotif::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sms:send')->everyMinute();
        $schedule->command('cancel:exceeding')->everyMinute();

        // $schedule->call(function () {
        //     Log::info('Scheduled task is running...');

        //     ParkPrice::create([
        //         'park_price'=> 100
        //     ]);

        // })->everyMinute();

        // $schedule->command('inspire')->hourly();
        // $schedule->call(function () {
        //     // DB::table('test')->insert([
        //     //     'testmsg' => 'schedule insert',
        //     // ]);

            
        //     $beforeDay = date('Y-m-d H:i', strtotime('+24 hour', strtotime(date('Y-m-d H:i')))); 

        //     $data = \DB::table('appointments')
        //         ->where('appoint_date', date('Y-m-d', strtotime($beforeDay)))
        //         ->where('appoint_time', date('H:i', strtotime($beforeDay)))
        //         ->where('is_notify', 0)
        //         ->get();
        
        //     foreach($data as $i){

        //         $user = User::find($i->user_id);

        //         $msg = 'Hi '.$user->lname . ', ' . $user->fname . ', this is just a reminder that you have an appointment tomorrow. Your ref no. is: ' . $i->qr_code . '.';
        //         try{ 
        //             Http::withHeaders([
        //                 'Content-Type' => 'text/plain'
        //             ])->post('http://'. env('IP_SMS_GATEWAY') .'/services/api/messaging?Message='.$msg.'&To='.$user->contact_no.'&Slot=1', []);
        //         }catch(Exception $e){} //just hide the error

        //         $appoint = Appointment::find($i->appointment_id);
        //         $appoint->is_notify = 1;
        //         $appoint->save();
        //     }


        // })->everyMinute(); //loop everyminute
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

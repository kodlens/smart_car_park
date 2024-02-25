<?php

namespace App\Console\Commands;
use App\Models\ParkReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Console\Command;

class SMSNotif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $beforeEnter = Carbon::now()->addMinutes(10);
        $errorEnter = Carbon::now()->addMinutes(11);
        $enter = ParkReservation::whereBetween('start_time', [$beforeEnter, $errorEnter])->with('user')->with('park')->get();

        $beforeExit = Carbon::now()->addMinutes(30);
        $errorExit = Carbon::now()->addMinutes(31);
        $exit = ParkReservation::whereBetween('start_time', [$beforeExit, $errorExit])->with('user')->with('park')->get();

        $apiKey =  env('SEND_SMS');
        if ($enter) {
            foreach ($enter as $user) {
                $ch = curl_init();
                $parameters = array(
                    'apikey' => $apiKey,
                    'number' => $user->user->contact_no,
                    'message' => 'Reminders Mr/Mrs. ' . $user->user->lname . ': \nYour ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will start 10 minutes from now.\nThank You!',
                    'sendername' => 'SEMAPHORE'
                );
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/priority');
                curl_setopt($ch, CURLOPT_POST, 1);

                //Send the parameters set above with the request
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

                // Receive response from server
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);
            } //end foreach
        }
        if ($exit) {
            foreach ($exit as $user) {
                $ch = curl_init();
                $parameters = array(
                    'apikey' => $apiKey,
                    'number' => $user->user->contact_no,
                    'message' => 'Reminders Mr/Mrs. ' . $user->user->lname . ': \nYour ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will end 30 minutes from now.\nThank You!',
                    'sendername' => 'SEMAPHORE'
                );
                return $parameters;
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/priority');
                curl_setopt($ch, CURLOPT_POST, 1);

                //Send the parameters set above with the request
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

                // Receive response from server
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);
            } //end foreach
        }
        return 0;
    }
}

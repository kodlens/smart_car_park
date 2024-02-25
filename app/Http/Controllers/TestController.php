<?php

namespace App\Http\Controllers;

use App\Models\ParkReservation;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TestController extends Controller
{
    public function Test()
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

        return $output;
    }
}

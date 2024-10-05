<?php

namespace App\Console\Commands;
use App\Models\ParkReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Mail\EntranceMailNotif;
use App\Mail\ExitMailNotif;
use Illuminate\Support\Facades\Mail;


use App\Models\SmsLog;

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
        if(env('SEMAPHORE_SERVICE') == 1){
            $this->semaphoreSMS();
        }

        if(env('SEMYSMS_SERVICE') == 1){
            $this->semySMS();
        }

        if(env('EMAIL_NOTIF') == 1){
            $this->emailNotif();
        }
        
    }

    public function emailNotif(){
        
        $settings = \DB::table('settings')->get();
        $notifBeforeEntrance = $settings->firstWhere('setting_name', 'notif_before_entrance');
        $notifPriorExit = $settings->firstWhere('setting_name', 'notif_prior_exit');

        $beforeEnter = Carbon::now()->addMinutes((int)$notifBeforeEntrance->setting_value);
        $errorEnter = Carbon::now()->addMinutes(((int)$notifBeforeEntrance->setting_value) + 1);
        $enter = ParkReservation::whereBetween('start_time', [$beforeEnter, $errorEnter])->with('user')->with('park')->get();

        $beforeExit = Carbon::now()->addMinutes((int)$notifPriorExit->setting_value);
        $errorExit = Carbon::now()->addMinutes(((int)$notifPriorExit->setting_value) + 1);
        $exit = ParkReservation::whereBetween('end_time', [$beforeExit, $errorExit])->with('user')->with('park')->get();
        
        if ($enter) {
            foreach ($enter as $user) {
                //$msg = 'Reminders Mr/Mrs. ' . $user->user->lname . ': \nYour ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will start 10 minutes from now. Thank You!';
                
                $data = [
                    'lname' => $user->user->lname,
                    'name' => $user->user->lname . ', ' . $user->user->fname,
                    'hour' => $user->hour,
                    'park_name' => $user->park->name,
                    'no_mins' => $notifBeforeEntrance->setting_value
                    
                ];

                Mail::to($user->user->email)->send(new EntranceMailNotif($data));

                SmsLog::create([
                    'contact_no' => $user->user->contact_no,
                    'email' => $user->user->email,
                    'remarks' => 'ENTRANCE/EMAIL',
                    'recipient' => $user->user->lname . ', ' . $user->user->fname,
                    'msg' => 'Message is on email template',

                ]);

            } //end foreach
        }


        if ($exit) {
            foreach ($exit as $user) {
                //$msg = 'Reminders Mr/Mrs. ' . $user->user->lname . ': \nYour ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will start 10 minutes from now. Thank You!';
                
                $data = [
                    'lname' => $user->user->lname,
                    'name' => $user->user->lname . ', ' . $user->user->fname,
                    'hour' => $user->hour,
                    'park_name' => $user->park->name,
                    'no_mins' => $notifPriorExit->setting_value
                ];

                Mail::to($user->user->email)->send(new ExitMailNotif($data));

                SmsLog::create([
                    'contact_no' => $user->user->contact_no,
                    'email' => $user->user->email,
                    'remarks' => 'EXIT/EMAIL',
                    'recipient' => $user->user->lname . ', ' . $user->user->fname,
                    'msg' => 'Message is on email template',

                ]);

            } //end foreach
        }

    }

    public function semaphoreSMS(){

        $beforeEnter = Carbon::now()->addMinutes(10);
        $errorEnter = Carbon::now()->addMinutes(11);
        $enter = ParkReservation::whereBetween('start_time', [$beforeEnter, $errorEnter])->with('user')->with('park')->get();

        $beforeExit = Carbon::now()->addMinutes(30);
        $errorExit = Carbon::now()->addMinutes(31);
        $exit = ParkReservation::whereBetween('end_time', [$beforeExit, $errorExit])->with('user')->with('park')->get();

        $apiKey =  env('SEND_SMS');

        if ($enter) {
            foreach ($enter as $user) {
                $ch = curl_init();
                $msg = 'Reminders Mr/Mrs. ' . $user->user->lname . ': \nYour ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will start 10 minutes from now. Thank You!';
                $parameters = array(
                    'apikey' => $apiKey,
                    'number' => $user->user->contact_no,
                    'message' =>  $msg,
                    'sendername' => 'SEMAPHORE'
                );
                // curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/priority');
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);

                //Send the parameters set above with the request
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

                // Receive response from server
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);

                SmsLog::create([
                    'contact_no' => $user->user->contact_no,
                    'remarks' => 'ENTRANCE',
                    'recipient' => $user->user->lname . ', ' . $user->user->fname,
                    'msg' => $msg,

                ]);

            } //end foreach
        }

        
        if ($exit) {
            foreach ($exit as $user) {
                $ch = curl_init();
                $msg = 'Reminders Mr/Mrs. ' . $user->user->lname . ': \nYour ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will end 30 minutes from now. Thank You!';

                $parameters = array(
                    'apikey' => $apiKey,
                    'number' => $user->user->contact_no,
                    'message' => $msg,
                    'sendername' => 'SEMAPHORE'
                );
                return $parameters;
                //curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/priority');
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);

                //Send the parameters set above with the request
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

                // Receive response from server
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);

                SmsLog::create([
                    'contact_no' => $user->user->contact_no,
                    'remarks' => 'EXIT',
                    'recipient' => $user->user->lname . ', ' . $user->user->fname,
                    'msg' => $msg,

                ]);
            } //end foreach
        }
    }

    public function semySMS(){

        $beforeEnter = Carbon::now()->addMinutes(10);
        $errorEnter = Carbon::now()->addMinutes(11);
        $enter = ParkReservation::whereBetween('start_time', [$beforeEnter, $errorEnter])->with('user')->with('park')->get();

        $beforeExit = Carbon::now()->addMinutes(30);
        $errorExit = Carbon::now()->addMinutes(31);
        $exit = ParkReservation::whereBetween('end_time', [$beforeExit, $errorExit])->with('user')->with('park')->get();

        $apiKey =  env('SEMY_SMS_API_TOKEN');
        $url =  env('SEMY_SMS_URL');
        $device = '1';  //  Device code

        

        if ($enter) {
            foreach ($enter as $user) {
                $msg = 'Reminders Mr/Mrs. ' . $user->user->lname . ': \nYour ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will start 10 minutes from now. Thank You!';
                $contact = $user->user->contact_no;

                //logic for gateway here...
               
                $data = array(
                    "phone" => $contact,
                    "msg" => $msg,
                    "device" => $device,
                    "token" => $apiKey
                );
               
                   $curl = curl_init($url);
                   curl_setopt($curl, CURLOPT_POST, true);
                   curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                   curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
                   $output = curl_exec($curl);
                   curl_close($curl);

                SmsLog::create([
                    'contact_no' => $contact,
                    'remarks' => 'ENTRANCE',
                    'recipient' => $user->user->lname . ', ' . $user->user->fname,
                    'msg' => $msg,

                ]);

            } //end foreach
        }

        
        if ($exit) {

            foreach ($exit as $user) {
                $msg = 'Reminders Mr/Mrs. ' . $user->user->lname . ': \nYour ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will end 30 minutes from now. Thank You!';
                $contact = $user->user->contact_no;
                
                //logic for gateway here...
               

                $data = array(
                    "phone" => $contact,
                    "msg" => $msg,
                    "device" => $device,
                    "token" => $apiKey
                );
               
                   $curl = curl_init($url);
                   curl_setopt($curl, CURLOPT_POST, true);
                   curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                   curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
                   $output = curl_exec($curl);
                   curl_close($curl);

                SmsLog::create([
                    'contact_no' => $contact,
                    'remarks' => 'ENTRANCE',
                    'recipient' => $user->user->lname . ', ' . $user->user->fname,
                    'msg' => $msg,

                ]);

                SmsLog::create([
                    'contact_no' => $user->user->contact_no,
                    'remarks' => 'EXIT',
                    'recipient' => $user->user->lname . ', ' . $user->user->fname,
                    'msg' => $msg,

                ]);
            } //end foreach
        }
    }

    /**THIS IS FOR TESTING SEMAPHORE */
    // public function mySMS(){
    //     $apiKey =  env('SEND_SMS');
    //     $ch = curl_init();
    //     $parameters = array(
    //         'apikey' => $apiKey,
    //         'number' => '09706102876',
    //         'message' => 'SMS Test',
    //         'sendername' => 'SEMAPHORE'
    //     );
    //     curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    //     curl_setopt($ch, CURLOPT_POST, 1);

    //     //Send the parameters set above with the request
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

    //     // Receive response from server
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $output = curl_exec($ch);
    //     curl_close($ch);
    // }

    public function mySemySMS(){

        
        $apiKey =  env('SEMY_SMS_API_TOKEN');
        $url =  env('SEMY_SMS_URL');
        $device = '1';  //  Device code
       
        $msg = 'This is automated SMS using SEMYSMS!';
        $contact = '09683013603';
                
        //logic for gateway here...    

        $data = array(
            "phone" => $contact,
            "msg" => $msg,
            "device" => $device,
            "token" => $apiKey
        );
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
        $output = curl_exec($curl);
        curl_close($curl);

        SmsLog::create([
            'contact_no' => $contact,
            'remarks' => 'TEST',
            'recipient' => 'AMPARADO',
            'msg' => 'TEST OF SEMYSMS',
        ]);

    }
}

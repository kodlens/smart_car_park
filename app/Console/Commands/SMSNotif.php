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
            $this->sendSemaphoreSMS();
        }

        if(env('EMAIL_NOTIF') == 1){
            $this->sendEmailNotif();
        }
        
    }

    public function sendEmailNotif(){
        
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

    public function sendSMS($mobile, $msg, $remarks, $recipientName){
        $apiKey =  env('SEND_SMS');
        $parameters = array(
            'apikey' => $apiKey,
            'number' => $mobile,
            'message' =>  $msg,
            'sendername' => 'CARSYS'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);

        //Send the parameters set above with the request
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

        // Receive response from server
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        SmsLog::create([
            'contact_no' => $mobile,
            'remarks' => $remarks,
            'recipient' => $recipientName,
            'msg' => $msg,
        ]);
    }

    public function sendSemaphoreSMS(){
        
        $settings = \DB::table('settings')->get();
        $notifBeforeEntrance = $settings->firstWhere('setting_name', 'notif_before_entrance');
        $notifPriorExit = $settings->firstWhere('setting_name', 'notif_prior_exit');

        $beforeEnter = Carbon::now()->addMinutes($notifBeforeEntrance);
        $errorEnter = Carbon::now()->addMinutes(((int)$notifBeforeEntrance + 1));
        $enter = ParkReservation::whereBetween('start_time', [$beforeEnter, $errorEnter])->with('user')->with('park')->get();

        $beforeExit = Carbon::now()->addMinutes($notifPriorExit);
        $errorExit = Carbon::now()->addMinutes(((int)$notifPriorExit + 1));
        $exit = ParkReservation::whereBetween('end_time', [$beforeExit, $errorExit])->with('user')->with('park')->get();


        if ($enter) {
            foreach ($enter as $user) {

                $msg = 'Reminders Mr/Mrs. ' . $user->user->lname . ': Your ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will start '. $notifBeforeEntrance.' minute(s) from now. Thank You!';
                $contactNo = $user->user->contact_no;
                $remarks = 'ENTRANCE/SMS';
                $recipientName = $user->user->lname . ', ' . $user->user->fname;

                $this->sendSMS($contactNo, $msg, $remarks, $recipientName);

            } //end foreach
        }
        
        if ($exit) {
            foreach ($exit as $user) {

                $msg = 'Reminders Mr/Mrs. ' . $user->user->lname . ': Your ' . $user->hour . ' hr(s) Park Reservation at ' . $user->park->name . ' will end '. $notifPriorExit.' minute(s) from now. Thank You!';
                $contactNo = $user->user->contact_no;
                $remarks = 'EXIT/SMS';
                $recipientName = $user->user->lname . ', ' . $user->user->fname;

                $this->sendSMS($contactNo, $msg, $remarks, $recipientName);

            } //end foreach
        }
    }

    
}

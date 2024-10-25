<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Carbon;


use App\Models\ParkReservation;

class SMSTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_example()
    {
     
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

        $this->assertTrue(true);

        
    }
}

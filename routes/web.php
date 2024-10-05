<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/url', function () {
    $port = request()->getPort();
    return $hostWithPort = request()->getScheme() . '://'. request()->getHost() . ($port ? ':' . $port : '');
});


Auth::routes([
    'login' => true,
    'register' => false
]);



//Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
//Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'index']);
Route::post('/registration', [App\Http\Controllers\RegistrationController::class, 'store']);


//ADDRESS
Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);

Route::get('/load-parking-spaces', [App\Http\Controllers\ParkingSpacesController::class, 'loadParkingSpaces']);
Route::get('/load-parking-reservation', [App\Http\Controllers\ParkReservationController::class, 'loadParkReservation']);

Route::get('/dashboard', [App\Http\Controllers\Administrator\DashboardController::class, 'index']);
Route::get('/load-report', [App\Http\Controllers\Administrator\DashboardController::class, 'loadReport']);



// -----------------------ADMINSITRATOR-------------------------------------------
Route::middleware(['auth', 'admin'])->group(function(){

    // Route::get('/load-reports', [App\Http\Controllers\Administrator\AdminHomeController::class, 'loadReports']);
    Route::resource('/park-devices', App\Http\Controllers\Administrator\ParkController::class);
    Route::get('/get-park-devices', [App\Http\Controllers\Administrator\ParkController::class, 'getData']);

    Route::resource('/parking-fees', App\Http\Controllers\Administrator\ParkingFeeController::class);
    Route::get('/get-parking-fees', [App\Http\Controllers\Administrator\ParkingFeeController::class, 'getData']);

    Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
    Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getData']);

    Route::post('/user-reset-password/{userid}', [App\Http\Controllers\Administrator\UserController::class, 'resetPassword']);


    Route::get('/monthly-sales-report', [App\Http\Controllers\Report\MonthlySalesReportController::class, 'index']);
    Route::get('/load-monthly-sales-report', [App\Http\Controllers\Report\MonthlySalesReportController::class, 'loadMonthlySalesReport']);

    Route::get('/weekly-sales-report', [App\Http\Controllers\Report\WeeklySalesReportController::class, 'index']);
    Route::get('/load-weekly-sales-report', [App\Http\Controllers\Report\WeeklySalesReportController::class, 'loadWeeklySalesReport']);

});

// -----------------------ADMINSITRATOR-------------------------------------------





//  ------------------------USER -------------------------------------
Route::middleware(['auth', 'user'])->group(function(){
    Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index']);
    
    Route::resource('/my-reservations', App\Http\Controllers\User\MyReservationController::class);
    Route::get('/get-my-reservations', [App\Http\Controllers\User\MyReservationController::class, 'getData']);

    Route::get('/get-my-reservation/{id}', [App\Http\Controllers\User\MyReservationController::class, 'getMyReservation']);
  

    Route::resource('/my-profile', App\Http\Controllers\User\MyProfileController::class);
    Route::get('/load-profile', [App\Http\Controllers\User\MyProfileController::class, 'loadProfile']);

});


//paypal controller
Route::get('/paypal', [App\Http\Controllers\PaypalController::class, 'index']);
Route::post('/paypal/payment', [App\Http\Controllers\PaypalController::class, 'payment'])->name('paypal');
Route::get('/paypal/success', [App\Http\Controllers\PaypalController::class, 'success'])->name('paypal_success');
Route::get('/paypal/cancel', [App\Http\Controllers\PaypalController::class, 'cancel'])->name('paypal_cancel');


//paymongo controllers
Route::middleware(['auth'])->group(function(){

    Route::get('/paymongo/pay',[App\Http\Controllers\PaymongoController::class,'pay']);
    Route::get('/paymongo/success',[App\Http\Controllers\PaymongoController::class,'success']);

    Route::get('/paymongo/pay-extend',[App\Http\Controllers\PaymongoController::class,'payExtend']);
    Route::get('/paymongo/success-extend',[App\Http\Controllers\PaymongoController::class,'successExtend']);

    
    Route::post('/exit-park',[App\Http\Controllers\ParkReservationController::class,'exitPark']);
    Route::post('/enter-park',[App\Http\Controllers\ParkReservationController::class,'enterPark']);
    
});



//  ------------------------SCANNER -------------------------------------
Route::middleware(['auth', 'scanner'])->group(function(){
    Route::resource('/scanner-home', App\Http\Controllers\Scanner\ScannerHomeController::class);
    Route::post('/decode-qr/{qr}', [App\Http\Controllers\Scanner\ScannerHomeController::class, 'decodeQr']);
});


Route::post('/exit-park/{id}',[App\Http\Controllers\Scanner\ScannerHomeController::class,'exitPark']);
Route::get('/test', [App\Http\Controllers\TestController::class, 'Test']);


//  ------------------------API SERVO------------------------------------

Route::get('/enter/{ip}', [App\Http\Controllers\ParkController::class, 'enter']);
Route::get('/exit/{ip}', [App\Http\Controllers\ParkController::class, 'exit']);



use App\Mail\EntranceMailNotif;
use Illuminate\Support\Facades\Mail;
use App\Models\SmsLog;
use App\Models\ParkReservation;
use Illuminate\Support\Carbon;

Route::get('/test-mail', function(){

    
    
    $settings = \DB::table('settings')->get();
    $notifBeforeEntrance = $settings->firstWhere('setting_name', 'notif_before_entrance');
    $notifPriorExit = $settings->firstWhere('setting_name', 'notif_prior_exit');

    $beforeEnter = Carbon::now()->addMinutes((int)$notifBeforeEntrance->setting_value);
    $errorEnter = Carbon::now()->addMinutes(((int)$notifBeforeEntrance->setting_value) + 1);

    $enter = ParkReservation::whereBetween('start_time', [$beforeEnter, $errorEnter])->with('user')->with('park')->get();

    $beforeExit = Carbon::now()->addMinutes((int)$notifPriorExit->setting_value);
    $errorExit = Carbon::now()->addMinutes(((int)$notifPriorExit->setting_value) + 1);
    $exit = ParkReservation::whereBetween('end_time', [$beforeExit, $errorExit])->with('user')->with('park')->get();
    
    return $exit;
    
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

});


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



Auth::routes([
    'login' => true,
    'register' => false
]);



//Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
//Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'index']);
// Route::post('/registration', [App\Http\Controllers\RegistrationController::class, 'store']);


//ADDRESS
Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);

Route::get('/load-parking-spaces', [App\Http\Controllers\ParkingSpacesController::class, 'loadParkingSpaces']);
Route::get('/load-parking-reservation', [App\Http\Controllers\ParkReservationController::class, 'loadParkReservation']);
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);



// -----------------------ADMINSITRATOR-------------------------------------------
Route::middleware(['auth', 'admin'])->group(function(){

    // Route::get('/load-reports', [App\Http\Controllers\Administrator\AdminHomeController::class, 'loadReports']);

    Route::resource('/parking-fees', App\Http\Controllers\Administrator\ParkingFeeController::class);
    Route::get('/get-parking-fees', [App\Http\Controllers\Administrator\ParkingFeeController::class, 'getData']);

    Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
    Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getData']);

    Route::post('/user-reset-password/{userid}', [App\Http\Controllers\Administrator\UserController::class, 'resetPassword']);

});

// -----------------------ADMINSITRATOR-------------------------------------------





//  ------------------------USER -------------------------------------
Route::middleware(['auth', 'user'])->group(function(){
    Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index']);
    
    
    Route::resource('/my-profile', App\Http\Controllers\User\MyProfileController::class);
    Route::get('/load-profile', [App\Http\Controllers\User\MyProfileController::class, 'loadProfile']);

});


//paypal controller
Route::get('/paypal', [App\Http\Controllers\PaypalController::class, 'index']);
Route::post('/paypal/payment', [App\Http\Controllers\PaypalController::class, 'payment'])->name('paypal');
Route::get('/paypal/success', [App\Http\Controllers\PaypalController::class, 'success'])->name('paypal_success');
Route::get('/paypal/cancel', [App\Http\Controllers\PaypalController::class, 'cancel'])->name('paypal_cancel');


//paymongo controllers

Route::get('/paymongo/pay',[App\Http\Controllers\PaymongoController::class,'pay']);
Route::get('/paymongo/success',[App\Http\Controllers\PaymongoController::class,'success']);

Route::post('/exit-park',[App\Http\Controllers\ParkReservationController::class,'exitPark']);
Route::post('/enter-park',[App\Http\Controllers\ParkReservationController::class,'enterPark']);



//  ------------------------SCANNER -------------------------------------
Route::middleware(['auth', 'scanner'])->group(function(){
    Route::resource('/scanner-home', App\Http\Controllers\Scanner\ScannerHomeController::class);
    Route::get('/decode-qr/{qr}', [App\Http\Controllers\Scanner\ScannerHomeController::class, 'decodeQr']);
});


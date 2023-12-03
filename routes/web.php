<?php


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

Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'index']);
Route::post('/registration', [App\Http\Controllers\RegistrationController::class, 'store']);


//ADDRESS
Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);



// -----------------------ADMINSITRATOR-------------------------------------------
Route::middleware(['auth', 'admin'])->group(function(){

    Route::get('/dashboard', [App\Http\Controllers\Administrator\DashboardController::class, 'index']);
    Route::get('/load-reports', [App\Http\Controllers\Administrator\AdminHomeController::class, 'loadReports']);

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

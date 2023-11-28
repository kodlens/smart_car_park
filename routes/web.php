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



Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'index']);
Route::post('/registration', [App\Http\Controllers\RegistrationController::class, 'store']);


Route::get('/get-user/{id}', [App\Http\Controllers\OpenUserController::class, 'getUser']);


//ADDRESS
Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);

Route::get('/load-academic-years', [App\Http\Controllers\OpenController::class, 'loadAcademicYears']);
Route::get('/load-grade-levels', [App\Http\Controllers\OpenController::class, 'loadGradeLevels']);
Route::get('/load-semesters', [App\Http\Controllers\OpenController::class, 'loadSemesters']);
Route::get('/load-tracks', [App\Http\Controllers\OpenController::class, 'loadTracks']);
Route::get('/load-strands', [App\Http\Controllers\OpenController::class, 'loadStrands']);


// -----------------------ADMINSITRATOR-------------------------------------------



Route::middleware(['auth', 'admin'])->group(function(){

    Route::get('/admin-home', [App\Http\Controllers\Administrator\AdminHomeController::class, 'index']);
    Route::get('/load-reports', [App\Http\Controllers\Administrator\AdminHomeController::class, 'loadReports']);

    Route::resource('/academic-years', App\Http\Controllers\Administrator\AcademicYearController::class);
    Route::get('/get-academic-years', [App\Http\Controllers\Administrator\AcademicYearController::class, 'getAcademicYears']);

    Route::resource('/tracks', App\Http\Controllers\Administrator\TrackController::class);
    Route::get('/get-tracks', [App\Http\Controllers\Administrator\TrackController::class, 'getTracks']);

    Route::resource('/strands', App\Http\Controllers\Administrator\StrandController::class);
    Route::get('/get-strands', [App\Http\Controllers\Administrator\StrandController::class, 'getStrands']);
    Route::post('/add-course', [App\Http\Controllers\Administrator\StrandController::class, 'addCourse']);


    Route::resource('/strand-courses', App\Http\Controllers\Administrator\StrandCourseController::class);
    Route::get('/get-strand-courses', [App\Http\Controllers\Administrator\StrandController::class, 'getStrandCourses']);


    Route::resource('/sections', App\Http\Controllers\Administrator\SectionController::class);
    Route::get('/get-sections', [App\Http\Controllers\Administrator\SectionController::class, 'getSections']);

    Route::resource('/courses', App\Http\Controllers\Administrator\CourseController::class);
    Route::get('/get-courses', [App\Http\Controllers\Administrator\CourseController::class, 'getCourses']);
    Route::get('/get-browse-courses', [App\Http\Controllers\Administrator\CourseController::class, 'getBrowseCourses']);



    Route::resource('/manage-learners', App\Http\Controllers\Administrator\ManageLearnerController::class);
    Route::get('/get-learners', [App\Http\Controllers\Administrator\ManageLearnerController::class, 'getLearners']);


    Route::resource('/enrollee', App\Http\Controllers\Administrator\EnrolleeController::class);
    Route::get('/get-enrollees', [App\Http\Controllers\Administrator\EnrolleeController::class, 'getEnrollees']);



    Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
    Route::get('/get-accounts', [App\Http\Controllers\Administrator\UserController::class, 'getAccounts']);


    Route::post('/user-reset-password/{userid}', [App\Http\Controllers\Administrator\UserController::class, 'resetPassword']);


    Route::post('/academic-year-active/{id}', [App\Http\Controllers\Administrator\AcademicYearController::class, 'active']);


    // PRINT
    Route::get('/print/print-page-coe', [App\Http\Controllers\Administrator\Print\PrintCoeController::class, 'index']);


    

});



// -----------------------ADMINSITRATOR-------------------------------------------



//open links
Route::get('/load-open-academic-years', [App\Http\Controllers\OpenController::class, 'loadAcademicYears']);
Route::get('/load-open-religions', [App\Http\Controllers\OpenController::class, 'loadReligions']);





Route::get('/session', function(){
    return Session::all();
});



Route::get('/applogout', function(Request $req){
    \Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();


});

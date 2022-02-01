<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Administration\AdministrationController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Father\FatherController;
use App\Http\Controllers\Professor\ProfessorController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Validation\Rules\Password as RulesPassword;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Start Routes Api < ADMIN >
Route::group([

    'middleware' => 'api',
    'prefix' => 'v1/admin'

], function ($router) {

    Route::post('login',[ AuthController::class, 'login' ])->name('admin.'); // Login Admin
    Route::post('logout',[ AuthController::class, 'logout' ])->name('admin.'); // Logout Admin
    Route::post('refresh',[ AuthController::class, 'refresh' ])->name('admin.'); // Refresh Admin
    Route::post('me',[ AuthController::class, 'me' ])->name('admin.'); // Auth Admin
    Route::post('store',[ AuthController::class, 'store' ])->name('admin.'); // Create Admin
    Route::get('index',[ AuthController::class, 'index' ])->name('admin.'); // Lists Admin
    Route::post('update/{id}',[ AuthController::class, 'update' ])->name('admin.'); // Update Admin 
    Route::get('trashed',[ AuthController::class, 'trashed' ])->name('admin.'); // Trashed Admin 
    Route::delete('destroy/{id}',[ AuthController::class, 'destroy' ])->name('admin.'); // Destroy Admin 
    Route::post('restore/{id}',[ AuthController::class, 'restore' ])->name('admin.'); // Restore Admin 
    Route::post('forced/{id}',[ AuthController::class, 'forced' ])->name('admin.'); // Forced Admin 
    Route::post('/forgot-password',[ AuthController::class, 'forgotpassword' ])->name('admin.'); // Forgot Password Admin 
    Route::post('/reset-password',[ AuthController::class, 'resetpassword' ])->name('admin.'); // Forgot Password Admin

});
 
// Start Routes Api < ADMINISTRATIONS >

// Start Routes Api < ADMINISTRATIONS >
Route::group([

   'middleware' => 'api',
   'prefix' => 'v1/administration'

],   function ($router) {

    Route::post('login',[ AdministrationController::class, 'login' ])->name('administration.'); // Administration Login
    Route::post('logout',[ AdministrationController::class, 'logout' ])->name('administration.'); // Logout Administration
    Route::post('refresh',[ AdministrationController::class, 'refresh' ])->name('administration.'); // Refresh Administration
    Route::post('me',[ AdministrationController::class, 'me' ])->name('administration.'); // Auth Administration
    Route::post('store',[ AdministrationController::class, 'store' ])->name('administration.'); // Create Administration
    Route::get('index',[ AdministrationController::class, 'index' ])->name('administration.'); // Lists Administration
    Route::post('update/{id}',[ AdministrationController::class, 'update' ])->name('administration.'); // Update Administration 
    Route::get('trashed',[ AdministrationController::class, 'trashed' ])->name('administration.'); // Trashed Administration 
    Route::delete('destroy/{id}',[ AdministrationController::class, 'destroy' ])->name('administration.'); // Destroy Administration 
    Route::post('restore/{id}',[ AdministrationController::class, 'restore' ])->name('administration.'); // Restore Administration 
    Route::post('forced/{id}',[ AdministrationController::class, 'forced' ])->name('administration.'); // Forced Administration 
    Route::post('/forgot-password',[ AdministrationController::class, 'forgotpassword' ])->name('administration.'); // Forgot Password Administration 
    Route::post('/reset-password',[ AdministrationController::class, 'resetpassword' ])->name('administration.'); // Forgot Password Administration

});
// End Routes Api < ADMINISTRATIONS >

// Start Routes Api < PROFESSOR >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/professor'
 
 ],   function ($router) {
 
     Route::post('login',[ ProfessorController::class, 'login' ])->name('professor.'); // PROFESSOR Login
     Route::post('logout',[ ProfessorController::class, 'logout' ])->name('professor.'); // Logout PROFESSOR
     Route::post('refresh',[ ProfessorController::class, 'refresh' ])->name('professor.'); // Refresh PROFESSOR
     Route::post('me',[ ProfessorController::class, 'me' ])->name('professor.'); // Auth PROFESSOR
     Route::post('store',[ ProfessorController::class, 'store' ])->name('professor.'); // Create PROFESSOR
     Route::get('index',[ ProfessorController::class, 'index' ])->name('professor.'); // Lists PROFESSOR
     Route::post('update/{id}',[ ProfessorController::class, 'update' ])->name('professor.'); // Update PROFESSOR 
     Route::get('trashed',[ ProfessorController::class, 'trashed' ])->name('professor.'); // Trashed PROFESSOR 
     Route::delete('destroy/{id}',[ ProfessorController::class, 'destroy' ])->name('professor.'); // Destroy PROFESSOR 
     Route::post('restore/{id}',[ ProfessorController::class, 'restore' ])->name('professor.'); // Restore PROFESSOR 
     Route::post('forced/{id}',[ ProfessorController::class, 'forced' ])->name('professor.'); // Forced PROFESSOR 
     Route::post('/forgot-password',[ ProfessorController::class, 'forgotpassword' ])->name('professor.'); // Forgot Password PROFESSOR 
     Route::post('/reset-password',[ ProfessorController::class, 'resetpassword' ])->name('professor.'); // Forgot Password PROFESSOR
 
 });
 // End Routes Api < PROFESSOR >

 // Start Routes Api < STUDENT >
Route::group([

    //'middleware' => 'students',
    'prefix' => 'v1/student'
 
 ],   function ($router) {
 
     Route::post('login',[ StudentController::class, 'login' ])->name('student.'); // Student Login
     Route::post('logout',[ StudentController::class, 'logout' ])->name('student.'); // Logout Student
     Route::post('refresh',[ StudentController::class, 'refresh' ])->name('student.'); // Refresh Student
     Route::post('me',[ StudentController::class, 'me' ])->name('student.'); // Auth Student
     Route::post('store',[ StudentController::class, 'store' ])->name('student.'); // Create Student
     Route::get('index',[ StudentController::class, 'index' ])->name('student.'); // Lists Student
     Route::post('update/{id}',[ StudentController::class, 'update' ])->name('student.'); // Update Student 
     Route::get('trashed',[ StudentController::class, 'trashed' ])->name('student.'); // Trashed Student 
     Route::delete('destroy/{id}',[ StudentController::class, 'destroy' ])->name('student.'); // Destroy Student 
     Route::post('restore/{id}',[ StudentController::class, 'restore' ])->name('student.'); // Restore Student 
     Route::post('forced/{id}',[ StudentController::class, 'forced' ])->name('student.'); // Forced Student 
     Route::post('/forgot-password',[ StudentController::class, 'forgotpassword' ])->name('student.'); // Forgot Password Student 
     Route::post('/reset-password',[ StudentController::class, 'resetpassword' ])->name('student.'); // Forgot Password Student
 
 });
 // End Routes Api < STUDENT >

 // Start Routes Api < FATHER >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/father'
 
 ],   function ($router) {
 
     Route::post('login',[ FatherController::class, 'login' ])->name('father.'); // Father Login
     Route::post('logout',[ FatherController::class, 'logout' ])->name('father.'); // Logout Father
     Route::post('refresh',[ FatherController::class, 'refresh' ])->name('father.'); // Refresh Father
     Route::post('me',[ FatherController::class, 'me' ])->name('father.'); // Auth Father
     Route::post('store',[ FatherController::class, 'store' ])->name('father.'); // Create Father
     Route::get('index',[ FatherController::class, 'index' ])->name('father.'); // Lists Father
     Route::post('update/{id}',[ FatherController::class, 'update' ])->name('father.'); // Update Father 
     Route::get('trashed',[ FatherController::class, 'trashed' ])->name('father.'); // Trashed Father 
     Route::delete('destroy/{id}',[ FatherController::class, 'destroy' ])->name('father.'); // Destroy Father 
     Route::post('restore/{id}',[ FatherController::class, 'restore' ])->name('father.'); // Restore Father 
     Route::post('forced/{id}',[ FatherController::class, 'forced' ])->name('father.'); // Forced Father 
     Route::post('/forgot-password',[ FatherController::class, 'forgotpassword' ])->name('father.'); // Forgot Password Father 
     Route::post('/reset-password',[ FatherController::class, 'resetpassword' ])->name('father.'); // Forgot Password Father
 
 });
 // End Routes Api < FATHER >

 // Start Routes Api < CONTACT >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/contacts',
 
 ],   function ($router) {
 
     Route::post('store',[ ContactController::class, 'store' ])->name('contact.'); // Create Contact
     Route::get('index',[ ContactController::class, 'index' ])->name('contact.'); // Lists Contact
     Route::get('trashed',[ ContactController::class, 'trashed' ])->name('contact.'); // Trashed Contact 
     Route::delete('destroy/{id}',[ ContactController::class, 'destroy' ])->name('contact.'); // Destroy Contact 
     Route::post('restore/{id}',[ ContactController::class, 'restore' ])->name('contact.'); // Restore Contact 
     Route::post('forced/{id}',[ ContactController::class, 'forced' ])->name('contact.'); // Forced Contact 
 
 });
 // End Routes Api < CONTACT >










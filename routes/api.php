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

    Route::post('login',[ AuthController::class, 'login' ]); // Login Admin
    Route::post('logout',[ AuthController::class, 'logout' ]); // Logout Admin
    Route::post('refresh',[ AuthController::class, 'refresh' ]); // Refresh Admin
    Route::post('me',[ AuthController::class, 'me' ]); // Auth Admin
    Route::post('store',[ AuthController::class, 'store' ]); // Create Admin
    Route::get('index',[ AuthController::class, 'index' ]); // Lists Admin
    Route::post('update/{id}',[ AuthController::class, 'update' ]); // Update Admin 
    Route::get('trashed',[ AuthController::class, 'trashed' ]); // Trashed Admin 
    Route::delete('destroy/{id}',[ AuthController::class, 'destroy' ]); // Destroy Admin 
    Route::post('restore/{id}',[ AuthController::class, 'restore' ]); // Restore Admin 
    Route::post('forced/{id}',[ AuthController::class, 'forced' ]); // Forced Admin 
    Route::post('/forgot-password',[ AuthController::class, 'forgotpassword' ]); // Forgot Password Admin 
    Route::post('/reset-password',[ AuthController::class, 'resetpassword' ]); // Forgot Password Admin

});
 
// Start Routes Api < ADMINISTRATIONS >

// Start Routes Api < ADMINISTRATIONS >
Route::group([

   //'middleware' => 'api',
   'prefix' => 'v1/administration'

],   function ($router) {

    Route::post('login',[ AdministrationController::class, 'login' ]); // Administration Login
    Route::post('logout',[ AdministrationController::class, 'logout' ]); // Logout Administration
    Route::post('refresh',[ AdministrationController::class, 'refresh' ]); // Refresh Administration
    Route::post('me',[ AdministrationController::class, 'me' ]); // Auth Administration
    Route::post('store',[ AdministrationController::class, 'store' ]); // Create Administration
    Route::get('index',[ AdministrationController::class, 'index' ]); // Lists Administration
    Route::post('update/{id}',[ AdministrationController::class, 'update' ]); // Update Administration 
    Route::get('trashed',[ AdministrationController::class, 'trashed' ]); // Trashed Administration 
    Route::delete('destroy/{id}',[ AdministrationController::class, 'destroy' ]); // Destroy Administration 
    Route::post('restore/{id}',[ AdministrationController::class, 'restore' ]); // Restore Administration 
    Route::post('forced/{id}',[ AdministrationController::class, 'forced' ]); // Forced Administration 
    Route::post('/forgot-password',[ AdministrationController::class, 'forgotpassword' ]); // Forgot Password Administration 
    Route::post('/reset-password',[ AdministrationController::class, 'resetpassword' ]); // Forgot Password Administration

});
// End Routes Api < ADMINISTRATIONS >

// Start Routes Api < PROFESSOR >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/professor'
 
 ],   function ($router) {
 
     Route::post('login',[ ProfessorController::class, 'login' ]); // PROFESSOR Login
     Route::post('logout',[ ProfessorController::class, 'logout' ]); // Logout PROFESSOR
     Route::post('refresh',[ ProfessorController::class, 'refresh' ]); // Refresh PROFESSOR
     Route::post('me',[ ProfessorController::class, 'me' ]); // Auth PROFESSOR
     Route::post('store',[ ProfessorController::class, 'store' ]); // Create PROFESSOR
     Route::get('index',[ ProfessorController::class, 'index' ]); // Lists PROFESSOR
     Route::post('update/{id}',[ ProfessorController::class, 'update' ]); // Update PROFESSOR 
     Route::get('trashed',[ ProfessorController::class, 'trashed' ]); // Trashed PROFESSOR 
     Route::delete('destroy/{id}',[ ProfessorController::class, 'destroy' ]); // Destroy PROFESSOR 
     Route::post('restore/{id}',[ ProfessorController::class, 'restore' ]); // Restore PROFESSOR 
     Route::post('forced/{id}',[ ProfessorController::class, 'forced' ]); // Forced PROFESSOR 
     Route::post('/forgot-password',[ ProfessorController::class, 'forgotpassword' ]); // Forgot Password PROFESSOR 
     Route::post('/reset-password',[ ProfessorController::class, 'resetpassword' ]); // Forgot Password PROFESSOR
 
 });
 // End Routes Api < PROFESSOR >

 // Start Routes Api < STUDENT >
Route::group([

    //'middleware' => 'students',
    'prefix' => 'v1/student'
 
 ],   function ($router) {
 
     Route::post('login',[ StudentController::class, 'login' ]); // Student Login
     Route::post('logout',[ StudentController::class, 'logout' ]); // Logout Student
     Route::post('refresh',[ StudentController::class, 'refresh' ]); // Refresh Student
     Route::post('me',[ StudentController::class, 'me' ]); // Auth Student
     Route::post('store',[ StudentController::class, 'store' ]); // Create Student
     Route::get('index',[ StudentController::class, 'index' ]); // Lists Student
     Route::post('update/{id}',[ StudentController::class, 'update' ]); // Update Student 
     Route::get('trashed',[ StudentController::class, 'trashed' ]); // Trashed Student 
     Route::delete('destroy/{id}',[ StudentController::class, 'destroy' ]); // Destroy Student 
     Route::post('restore/{id}',[ StudentController::class, 'restore' ]); // Restore Student 
     Route::post('forced/{id}',[ StudentController::class, 'forced' ]); // Forced Student 
     Route::post('/forgot-password',[ StudentController::class, 'forgotpassword' ]); // Forgot Password Student 
     Route::post('/reset-password',[ StudentController::class, 'resetpassword' ]); // Forgot Password Student
 
 });
 // End Routes Api < STUDENT >

 // Start Routes Api < FATHER >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/father'
 
 ],   function ($router) {
 
     Route::post('login',[ FatherController::class, 'login' ]); // Father Login
     Route::post('logout',[ FatherController::class, 'logout' ]); // Logout Father
     Route::post('refresh',[ FatherController::class, 'refresh' ]); // Refresh Father
     Route::post('me',[ FatherController::class, 'me' ]); // Auth Father
     Route::post('store',[ FatherController::class, 'store' ]); // Create Father
     Route::get('index',[ FatherController::class, 'index' ]); // Lists Father
     Route::post('update/{id}',[ FatherController::class, 'update' ]); // Update Father 
     Route::get('trashed',[ FatherController::class, 'trashed' ]); // Trashed Father 
     Route::delete('destroy/{id}',[ FatherController::class, 'destroy' ]); // Destroy Father 
     Route::post('restore/{id}',[ FatherController::class, 'restore' ]); // Restore Father 
     Route::post('forced/{id}',[ FatherController::class, 'forced' ]); // Forced Father 
     Route::post('/forgot-password',[ FatherController::class, 'forgotpassword' ]); // Forgot Password Father 
     Route::post('/reset-password',[ FatherController::class, 'resetpassword' ]); // Forgot Password Father
 
 });
 // End Routes Api < FATHER >

 // Start Routes Api < CONTACT >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/contacts'
 
 ],   function ($router) {
 
     Route::post('store',[ ContactController::class, 'store' ]); // Create Contact
     Route::get('index',[ ContactController::class, 'index' ]); // Lists Contact
     Route::get('trashed',[ ContactController::class, 'trashed' ]); // Trashed Contact 
     Route::delete('destroy/{id}',[ ContactController::class, 'destroy' ]); // Destroy Contact 
     Route::post('restore/{id}',[ ContactController::class, 'restore' ]); // Restore Contact 
     Route::post('forced/{id}',[ ContactController::class, 'forced' ]); // Forced Contact 
 
 });
 // End Routes Api < CONTACT >










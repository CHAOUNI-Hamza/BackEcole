<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    Route::post('login', 'App\Http\Controllers\User\AuthController@login'); // Login Admin
    Route::post('logout', 'App\Http\Controllers\User\AuthController@logout'); // Logout Admin
    Route::post('refresh', 'App\Http\Controllers\User\AuthController@refresh'); // Refresh Admin
    Route::post('me', 'App\Http\Controllers\User\AuthController@me'); // Auth Admin
    Route::post('store', 'App\Http\Controllers\User\AuthController@store'); // Create Admin
    Route::get('index', 'App\Http\Controllers\User\AuthController@index'); // Lists Admin
    Route::post('update/{id}', 'App\Http\Controllers\User\AuthController@update'); // Update Admin 
    Route::get('trashed', 'App\Http\Controllers\User\AuthController@trashed'); // Trashed Admin 
    Route::delete('destroy/{id}', 'App\Http\Controllers\User\AuthController@destroy'); // Destroy Admin 
    Route::post('restore/{id}', 'App\Http\Controllers\User\AuthController@restore'); // Restore Admin 
    Route::post('forced/{id}', 'App\Http\Controllers\User\AuthController@forced'); // Forced Admin 
    Route::post('/forgot-password', 'App\Http\Controllers\User\AuthController@forgotpassword'); // Forgot Password Admin 
    Route::post('/reset-password', 'App\Http\Controllers\User\AuthController@resetpassword'); // Forgot Password Admin

});
 
// Start Routes Api < ADMINISTRATIONS >

// Start Routes Api < ADMINISTRATIONS >
Route::group([

   //'middleware' => 'api',
   'prefix' => 'v1/administration'

],   function ($router) {

    Route::post('login', 'App\Http\Controllers\Administration\AdministrationController@login'); // Administration Login
    Route::post('logout', 'App\Http\Controllers\Administration\AdministrationController@logout'); // Logout Administration
    Route::post('refresh', 'App\Http\Controllers\Administration\AdministrationController@refresh'); // Refresh Administration
    Route::post('me', 'App\Http\Controllers\Administration\AdministrationController@me'); // Auth Administration
    Route::post('store', 'App\Http\Controllers\Administration\AdministrationController@store'); // Create Administration
    Route::get('index', 'App\Http\Controllers\Administration\AdministrationController@index'); // Lists Administration
    Route::post('update/{id}', 'App\Http\Controllers\Administration\AdministrationController@update'); // Update Administration 
    Route::get('trashed', 'App\Http\Controllers\Administration\AdministrationController@trashed'); // Trashed Administration 
    Route::delete('destroy/{id}', 'App\Http\Controllers\Administration\AdministrationController@destroy'); // Destroy Administration 
    Route::post('restore/{id}', 'App\Http\Controllers\Administration\AdministrationController@restore'); // Restore Administration 
    Route::post('forced/{id}', 'App\Http\Controllers\Administration\AdministrationController@forced'); // Forced Administration 
    Route::post('/forgot-password', 'App\Http\Controllers\Administration\AdministrationController@forgotpassword'); // Forgot Password Administration 
    Route::post('/reset-password', 'App\Http\Controllers\Administration\AdministrationController@resetpassword'); // Forgot Password Administration

});
// End Routes Api < ADMINISTRATIONS >

// Start Routes Api < PROFESSOR >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/professor'
 
 ],   function ($router) {
 
     Route::post('login', 'App\Http\Controllers\Professor\ProfessorController@login'); // PROFESSOR Login
     Route::post('logout', 'App\Http\Controllers\Professor\ProfessorController@logout'); // Logout PROFESSOR
     Route::post('refresh', 'App\Http\Controllers\Professor\ProfessorController@refresh'); // Refresh PROFESSOR
     Route::post('me', 'App\Http\Controllers\Professor\ProfessorController@me'); // Auth PROFESSOR
     Route::post('store', 'App\Http\Controllers\Professor\ProfessorController@store'); // Create PROFESSOR
     Route::get('index', 'App\Http\Controllers\Professor\ProfessorController@index'); // Lists PROFESSOR
     Route::post('update/{id}', 'App\Http\Controllers\Professor\ProfessorController@update'); // Update PROFESSOR 
     Route::get('trashed', 'App\Http\Controllers\Professor\ProfessorController@trashed'); // Trashed PROFESSOR 
     Route::delete('destroy/{id}', 'App\Http\Controllers\Professor\ProfessorController@destroy'); // Destroy PROFESSOR 
     Route::post('restore/{id}', 'App\Http\Controllers\Professor\ProfessorController@restore'); // Restore PROFESSOR 
     Route::post('forced/{id}', 'App\Http\Controllers\Professor\ProfessorController@forced'); // Forced PROFESSOR 
     Route::post('/forgot-password', 'App\Http\Controllers\Professor\ProfessorController@forgotpassword'); // Forgot Password PROFESSOR 
     Route::post('/reset-password', 'App\Http\Controllers\Professor\ProfessorController@resetpassword'); // Forgot Password PROFESSOR
 
 });
 // End Routes Api < PROFESSOR >

 // Start Routes Api < STUDENT >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/student'
 
 ],   function ($router) {
 
     Route::post('login', 'App\Http\Controllers\Student\StudentController@login'); // Student Login
     Route::post('logout', 'App\Http\Controllers\Student\StudentController@logout'); // Logout Student
     Route::post('refresh', 'App\Http\Controllers\Student\StudentController@refresh'); // Refresh Student
     Route::post('me', 'App\Http\Controllers\Student\StudentController@me'); // Auth Student
     Route::post('store', 'App\Http\Controllers\Student\StudentController@store'); // Create Student
     Route::get('index', 'App\Http\Controllers\Student\StudentController@index'); // Lists Student
     Route::post('update/{id}', 'App\Http\Controllers\Student\StudentController@update'); // Update Student 
     Route::get('trashed', 'App\Http\Controllers\Student\StudentController@trashed'); // Trashed Student 
     Route::delete('destroy/{id}', 'App\Http\Controllers\Student\StudentController@destroy'); // Destroy Student 
     Route::post('restore/{id}', 'App\Http\Controllers\Student\StudentController@restore'); // Restore Student 
     Route::post('forced/{id}', 'App\Http\Controllers\Student\StudentController@forced'); // Forced Student 
     Route::post('/forgot-password', 'App\Http\Controllers\Student\StudentController@forgotpassword'); // Forgot Password Student 
     Route::post('/reset-password', 'App\Http\Controllers\Student\StudentController@resetpassword'); // Forgot Password Student
 
 });
 // End Routes Api < STUDENT >

 // Start Routes Api < FATHER >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/father'
 
 ],   function ($router) {
 
     Route::post('login', 'App\Http\Controllers\Father\FatherController@login'); // Father Login
     Route::post('logout', 'App\Http\Controllers\Father\FatherController@logout'); // Logout Father
     Route::post('refresh', 'App\Http\Controllers\Father\FatherController@refresh'); // Refresh Father
     Route::post('me', 'App\Http\Controllers\Father\FatherController@me'); // Auth Father
     Route::post('store', 'App\Http\Controllers\Father\FatherController@store'); // Create Father
     Route::get('index', 'App\Http\Controllers\Father\FatherController@index'); // Lists Father
     Route::post('update/{id}', 'App\Http\Controllers\Father\FatherController@update'); // Update Father 
     Route::get('trashed', 'App\Http\Controllers\Father\FatherController@trashed'); // Trashed Father 
     Route::delete('destroy/{id}', 'App\Http\Controllers\Father\FatherController@destroy'); // Destroy Father 
     Route::post('restore/{id}', 'App\Http\Controllers\Father\FatherController@restore'); // Restore Father 
     Route::post('forced/{id}', 'App\Http\Controllers\Father\FatherController@forced'); // Forced Father 
     Route::post('/forgot-password', 'App\Http\Controllers\Father\FatherController@forgotpassword'); // Forgot Password Father 
     Route::post('/reset-password', 'App\Http\Controllers\Father\FatherController@resetpassword'); // Forgot Password Father
 
 });
 // End Routes Api < FATHER >

  // Start Routes Api < CONTACT >
Route::group([

    //'middleware' => 'api',
    'prefix' => 'v1/contacts'
 
 ],   function ($router) {
 
     Route::post('store', 'App\Http\Controllers\Contact\ContactController@store'); // Create Contact
     Route::get('index', 'App\Http\Controllers\Contact\ContactController@index'); // Lists Contact
     Route::get('trashed', 'App\Http\Controllers\Contact\ContactController@trashed'); // Trashed Contact 
     Route::delete('destroy/{id}', 'App\Http\Controllers\Contact\ContactController@destroy'); // Destroy Contact 
     Route::post('restore/{id}', 'App\Http\Controllers\Contact\ContactController@restore'); // Restore Contact 
     Route::post('forced/{id}', 'App\Http\Controllers\Contact\ContactController@forced'); // Forced Contact 
 
 });
 // End Routes Api < CONTACT >










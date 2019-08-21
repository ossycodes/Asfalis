<?php

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'v1/auth',
    'namespace' => 'API'

], function ($router) {

    Route::post('/login', 'AuthController@login');
    //since i set the token TTL to null, (never giong to expire), then i don't need
    //the refresh endpoints
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/me', 'ProfileController@show');
    Route::post('/register', 'RegisterController@store');
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'v1',
    'namespace' => 'API'

], function ($router) {
    //notifies the user registered emergency contacts via sms
    //and email via USSD
    Route::post('/emergencyviaussd', 'EmergencyController@send');
    //notifies the user registered emergency contacts via sms
    //and email via the mobile application
    Route::post('/emergency', 'EmergencyController@notify');
    Route::patch('/profile', 'ProfileController@update');
    Route::patch('/password/update', 'UpdatePasswordController@update');
    Route::post('/password/reset', 'ForgetPasswordController@store');
    Route::post('/emergencycontacts', 'EmergencycontactsController@store');
    Route::get('/emergencycontacts', 'EmergencycontactsController@index');
    Route::get('/emergencycontacts/{emergencycontacts}', 'EmergencycontactsController@show');
    Route::patch('/emergencycontacts/{emergencycontacts}', 'EmergencycontactsController@update');
    Route::delete('/emergencycontacts/{emergencycontacts}', 'EmergencycontactsController@destroy');
});

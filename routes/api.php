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

use App\Components\Sms\SmsManager;
use App\Components\Sms\Facades\SMS;

Route::group([

    'middleware' => 'api',
    'prefix' => 'v1/auth',
    'namespace' => 'API'

], function ($router) {

    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/me', 'ProfileController@show');
    Route::post('/register', 'RegisterController@store');
});

Route::group([

    'prefix' => 'v1',
    'namespace' => 'API'

], function ($router) {
    Route::get('/emergencyagencies', 'EmergencylineController@index');
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'v1',
    'namespace' => 'API'

], function ($router) {
    Route::post('/ussd', 'EmergencyController@ussd');
    Route::post('/emergency', 'EmergencyController@emergency');
    Route::patch('/profile', 'ProfileController@update');
    Route::patch('/password/update', 'UpdatePasswordController@update');
    Route::post('/password/reset', 'ForgetPasswordController@store');
    Route::post('/emergencycontacts', 'EmergencycontactsController@store');
    Route::get('/emergencycontacts', 'EmergencycontactsController@index')->name("user.emergencycontacts");
    Route::get('/emergencycontacts/{id}', 'EmergencycontactsController@show')->name("emergencycontact.show");
    Route::patch('/emergencycontacts/{emergencycontacts}', 'EmergencycontactsController@update');
    Route::delete('/emergencycontacts/{id}', 'EmergencycontactsController@destroy');
    Route::get('users/{user}/relationships/emergencycontacts', function () {
        return true;
    })->name('users.relationships.emergencycontacts');
    Route::get('users/{users}/emergencycontacts', function () {
        return true;
    })->name('users.emergencycontacts');
    Route::post('testdrivers', function (SmsManager $sms) {
        // dump($sms->send());
        // dump($sms->channel('Africastalking')->send());
        dump(SMS::to('+2348034711579')->content('Test Message from Stay Safe Scheme')->send());
    });
});


//Admin Routes
Route::group([

    'prefix' => 'v1/admin',
    'namespace' => 'API\Admin'

], function ($router) {
    Route::get('news', 'NewsController@index')->name('news.all');
    Route::get('news/{id}', 'NewsController@show')->name('news.show');
    Route::post('news', 'NewsController@store')->name('news.store');
    Route::patch('news/{id}', 'NewsController@update')->name('news.update');
    Route::delete('news/{id}', 'NewsController@destroy')->name('news.destroy');
    Route::get('emergencyagencies', 'EmergencylinesController@index');
    Route::get('emergencyagencies/{id}', 'EmergencylinesController@show')->name('emergencyagencies.show');
    Route::post('emergencyagencies', 'EmergencylinesController@store');
    Route::patch('emergencyagencies/{id}', 'EmergencylinesController@update');
    Route::delete('emergencyagencies/{id}', 'EmergencylinesController@destroy');
    Route::get('tips', 'TipsController@index')->name('tips.all');
    Route::get('tips/{id}', 'TipsController@show')->name('tip.show');
    Route::post('tips', 'TipsController@store')->name('tip.store');
    Route::patch('tips/{id}', 'TipsController@update')->name('tip.update');
    Route::delete('tips/{id}', 'TipsController@destroy')->name('tip.destroy');
    // Auth operation / middleware
    // Read Registered Users/EmergencyContacts Details
});

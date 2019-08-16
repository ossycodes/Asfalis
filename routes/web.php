<?php

use App\Example;
use App\Services\TwitterService;
use Illuminate\Filesystem\Filesystem;

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
    return view('welcome');
});


//this should be inside the AppServiceProvider or any other dedicated ServiceProvider
// app()->bind('twitter', function () {
//     return new App\Services\TwitterService('apikeyordetailsfromconfigfilegoesinhere');
// });

// You can then resolve this out of the container
// Route::get('/tb', function () {
//     $twitter = app('twitter');
//     dd($twitter);
// });


//2.
app()->bind(TwitterService::class, function () {
    return new App\Services\TwitterService('apikeyordetailsfromconfigfilegoesinhere');
});

Route::get('/tb', function (TwitterService $twitter) {
    dd($twitter);
});

// app()->bind('App\Example', function () {
//     //dd('i check the service provider first, before searching for the class itself');
//     return new App\Example;
// });

// Route::get('/tb', function (Filesystem $file) {
//     dd($file);
// });


// Route::get('/tb', function () {
//     dd(app('App\Example'));
//     // dd(app('my-example'));
// });

// Route::get('/tb', function () {
//     dd(app(Filesystem::class));
// });

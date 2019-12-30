<?php

namespace App\Providers;

use GuzzleHttp\Client;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
//use AfricasTalking\SDK\AfricasTalking;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(CustomServiceProvider::class);
    }
}

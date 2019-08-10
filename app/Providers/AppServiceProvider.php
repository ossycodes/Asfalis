<?php

namespace App\Providers;

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
        $this->app->singleton(AfricasTalking::class,function() {
            return new AfricasTalking(config('services.africastalking.username'), config('services.africastalking.apiKey'));
        });
    }
}

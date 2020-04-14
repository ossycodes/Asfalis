<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Contracts\UserRepositoryInterface', 'App\Repositories\Concretes\EloquentUserRepository');
        $this->app->bind('App\Repositories\Contracts\EmergencyContactsRepositoryInterface', 'App\Repositories\Concretes\EloquentEmergencyContactsRepository');
        $this->app->bind('App\Repositories\Contracts\EmergencylineInterface', 'App\Repositories\Concretes\EloquentEmergencylineRepository');
        $this->app->bind('App\Repositories\Contracts\TipsRepositoryInterface', 'App\Repositories\Concretes\EloquentTipsRepository');
        $this->app->bind('App\Repositories\Contracts\NewsRepositoryInterface', 'App\Repositories\Concretes\EloquentNewsRepository');
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserCreated' => [
            'App\Listeners\SendWelcomeMail', //send registered 
            //user a welcome email
        ],
        'App\Events\EmergencycontactCreated' => [
            'App\Listeners\SendECRegMail'//send emergencycontact a
            //mail informing them that a user just registered him/her details
            //incase of emergency
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

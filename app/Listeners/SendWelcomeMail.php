<?php

namespace App\Listeners;

use App\Mail\WelcomeEmail;
use App\Events\UserCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeMail implements ShouldQueue
{
    public $user;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $this->user = $event->user;

        Mail::to($this->user)->send(new WelcomeEmail($this->user));
    }
}

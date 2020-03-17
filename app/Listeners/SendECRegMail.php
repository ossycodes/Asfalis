<?php

namespace App\Listeners;

use App\Mail\ECRegEmail;
use Illuminate\Support\Facades\Mail;
use App\Events\EmergencycontactCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendECRegMail implements ShouldQueue
{
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  EmergencycontactCreated  $event
     * @return void
     */
    public function handle(EmergencycontactCreated $event)
    {
        Mail::to($event->emergencycontact)->send(new ECRegEmail($event->emergencycontact));
    }
}

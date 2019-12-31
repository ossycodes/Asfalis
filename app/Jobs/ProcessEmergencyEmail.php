<?php

namespace App\Jobs;

use App\User;
use App\Emergencycontacts;
use App\Mail\EmergencyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessEmergencyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emergencyContacts = $this->user->emergencycontacts;
        foreach ($emergencyContacts as $contact) { //move this to job handle method
            Mail::to($contact)->send(new EmergencyMail($contact->name, $this->user->full_name, "USSD")); //move this to job handle method
            //send sms
            //$this->sendSMS($user->name, \Illuminate\Support\Str::replaceFirst('0', '+234', $contact->phonenumber));
            // }
        }
    }
}

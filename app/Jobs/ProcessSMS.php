<?php

namespace App\Jobs;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Components\Sms\SmsManager;
use App\Components\Sms\Facades\SMS;

class ProcessSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $location;
    public $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $location)
    {
        $this->user = $user;
        $this->location = $location;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SmsManager $sms)
    {
        if (is_array($this->location)) {
            [$this->service, $this->location] = explode("*", $this->location);
        }
        $emergencyContacts = $this->user->emergencycontacts;
        $emergencyContactPhonenumbers =  $emergencyContacts->pluck("phonenumber")->all();
        $message = "{$this->user->full_name} is in an emergency situation, currently at {$this->location}, you are recieving this SMS because {$this->user->full_name} registered you as an In Case Of Emergency (I.C.E) contact,      FROM WESAFE";
        return $sms->to($emergencyContactPhonenumbers)->channel('Africastalking')->content($message)->send();
        
    }
}

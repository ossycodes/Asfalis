<?php

namespace App\Jobs;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSMS implements ShouldQueue
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
        $pluckedPhonenumbers = $emergencyContacts->pluck("phonenumber");
        $emergencyContactPhonenumbers = $pluckedPhonenumbers->all();
        // resolve('App\Services\SMSservice')->sendSMS($this->user->fullName, $emergencyContactPhonenumbers);
        // dump(SMS::to('+2348034711579')->content('Test Message from Stay Safe Scheme')->send());
    }
}

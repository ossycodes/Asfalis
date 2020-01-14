<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\NotifyEmergencyagenciesViaTwitter;

class ProcessNotifyEmergencyagenciesViaTwitter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $emergencyDetails;
    public $user;
    public $service;
    public $location;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emergencyDetails, $user)
    {
         $this->emergencyDetails = $emergencyDetails;
         $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        [$this->service, $this->location] = explode("*", $this->emergencyDetails);
        
        $this->user->notify(new NotifyEmergencyagenciesViaTwitter($this->user, $this->service, $this->location));
    }
}

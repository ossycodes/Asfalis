<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmergencyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emergencyContactName;
    public $user;
    public $userLocation;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emergencyContactName, $userLocation = null)
    {
        $this->emergencyContactName = $emergencyContactName;
        $this->user = auth()->user();
        $this->userLocation = $userLocation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.emergencymail');
    }
}

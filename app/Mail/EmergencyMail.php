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
    public function __construct($emergencyContactName, $userName, $context, $userLocation = null)
    {
        $this->emergencyContactName = $emergencyContactName;
        $this->user = $context === "USSD" ? $userName : auth()->user()->full_name;
        $this->userLocation = $userLocation ? "" : $userLocation;
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

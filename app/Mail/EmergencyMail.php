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
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emergencyContactName)
    {
        $this->emergencyContactName = $emergencyContactName;
        $this->user = auth()->user();
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

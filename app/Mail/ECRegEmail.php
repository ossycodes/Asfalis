<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ECRegEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emergencycontact;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emergencycontact)
    {
        $this->emergencycontact = $emergencycontact;
        $this->user = Auth()->user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Emergency Contact')->markdown('emails.ECRegMail');
    }
}

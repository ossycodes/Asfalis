<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $passwordResetToken;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($passwordResetToken)
    {
        $this->passwordResetToken = $passwordResetToken;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $passwordResetLink = url("/password/reset/{$this->passwordResetToken}");

        //checkout a standard reset password message
        return (new MailMessage)

            ->line('A request to reset your password has been made. If you did not make this request, simply ignore this email. If you did make this request just click the link below:')
            ->action('Reset link', $passwordResetLink)
            ->line('If the above URL does not work, try copying and pasting it into your browser. If you continue to experience problems please feel free to contact us.');

            //after reseting password inform the user
            //             Hi Osaigbovo,

            // The password for your Cloudinary account - osaigbovoemmanuel1@gmail.com - was recently changed. 
            // If you did not make this change, please reset your password to get back into your account. 

            // Thanks, 
            // The Cloudinary team. 

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

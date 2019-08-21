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
                    ->line('We recieved a request to reset your password')
                    ->line('Please click the reset link below to reset your password')
                    ->action('Reset link', $passwordResetLink)
                    ->line('All the best');
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

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\AfricasTalking\AfricasTalkingChannel;
use NotificationChannels\AfricasTalking\AfricasTalkingMessage;

class TestAbg extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return [AfricasTalkingChannel::class];
        return ['fcm'];
    }


    // public function toAfricasTalking($notifiable)
    // {
    // 	return (new AfricasTalkingMessage())
    //                 ->content('Your order #reference123 was placed');

    // }

    public function toFcm()
    {
        $message = new FcmMessage();
        $message->to(config('services.fcm.topic'), $recipientIsTopic = true)
            ->content([
                'title'        => 'Emergency !!!!',
                'body'         => 'Pipelin explosion at EBUTE META',
                // 'sound'        => '', // Optional 
                // 'icon'         => '', // Optional
                // 'click_action' => '' // Optional
            ])
            ->data([
                'param1' => 'baz' // Optional
            ]);
            // ->priority(FcmMessage::PRIORITY_HIGH); // Optional - Default is 'normal'.
        return $message;
    }
}

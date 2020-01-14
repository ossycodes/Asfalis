<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Twitter\TwitterChannel;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyEmergencyagenciesViaTwitter extends Notification implements ShouldQueue
{
    use Queueable;

    public $location;
    public $service;
    public $userName;

    public function __construct($user, $service, $location)
    {
        $this->user = $user;
        $this->service = $service;
        $this->location = $location;

        dd([$this->service, $this->location, $this->user]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwitterChannel::class];
    }

    public function toTwitter($notifiable)
    {
        $emergencyTwitterHandlesAsArray = config('services.emergencyagenciestwitterhandles');
        $emergencyTwitterHandlesAsString = implode(",", $emergencyTwitterHandlesAsArray);
        return new TwitterStatusUpdate("${$emergencyTwitterHandlesAsString}, {$this->userName} is currently in an emergency situation : {$this->service}. Location of user is: {$this->location}, From StaySafeNigeria");
    }
}

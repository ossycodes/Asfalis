<?php

namespace App\Http\Controllers\API\Admin;

use App\User;
use App\Http\Controllers\Controller;
use App\Notifications\EmergencySituationAlert;
use App\Http\Requests\CreateEmergencySituationRequest;
use App\Repositories\Contracts\UserRepositoryInterface;

class EmergencySituationController extends Controller
{
    public $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function alert(CreateEmergencySituationRequest $request)
    {
        $title = request()->input('data.attributes.title');
        $body = request()->input('data.attributes.body');

        /** works but change user to admin */
        $user = User::find(1);
        return $user->notify(new EmergencySituationAlert($title, $body));
        
        /** works */
        // return $this->send_notification($title, $body);
    }

    private function send_notification($title, $body)
    {
        //API frpm Firebase Cloud Messaging(FCM)
        $url = 'https://fcm.googleapis.com/fcm/send';

        $msg = [
            'body' => $body,
            'content_available' => true,
            'priority' => 'high',
            'title' => $title,
            'vibrate' => 1,
            'sound' => 1
        ];
        $data = [
            'body' => $body,
            'content_available' => true,
            'priority' => 'high',
            'title' => $title,
            'vibrate' => 1,
            'sound' => 1
        ];
        $fields = [
            'to' => '/topics/' . config('services.fcm.topic'),
            'notification' => $msg,
            'data' => $data
        ];
        $headers = [
            'Authorization: key=' . config('services.fcm.key'),
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('FCM Send Error:' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}

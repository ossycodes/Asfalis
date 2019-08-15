<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;

class SMSservice
{ 

    public function sendSMS($username, $recepients) {

        $recepient = \Illuminate\Support\Str::replaceFirst('0', '+234', $recepients->phonenumber);
        $AT = resolve(AfricasTalking::class);
        $sms = $AT->sms();
        $message = "Hi {$username} is in an emergency situation and currently needs your help";
        $from = "USECURED";

        try {
            $result = $sms->send([
                'to' => $recepient,
                'message' => $message,
                'from' => $from
            ]);
            
            return true;
            // print_r($result);
            
        } catch (Exception $e) {
            // return $e->getMessage();
            return false;
        }

        return true;

    }
}

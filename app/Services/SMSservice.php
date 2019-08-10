<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;

class SMSservice
{ 
    public function sendSMS($recepients) {
        dd('yeahh');
        dd(\Illuminate\Support\Str::replaceFirst('0', '+234', $recepients->phonenumber));
        // $sms = $AT->sms();
        // $user = auth()->user()->name;
        // $message = "Hi {$recepients->name}, {$user} is in an emergency situation and currently needs your help"
        // $re
        // $from = "USECURED";

        // try{
        //     $result = $sms->send([
        //         'to' => $recepients,
        //         'message' => $message,
        //         'from' => $from
        //     ]);

        //     print_r($result);
        // } catch(Exception $e) {
        //     return $e->getMessage();
        // }
    }
}

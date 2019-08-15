<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Mail\EmergencyMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use AfricasTalking\SDK\AfricasTalking;
use App\Http\Resources\Emergencycontacts;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Customresponses;

class EmergencyController extends Controller
{
    public function __construct(Customresponses $customResponse)
    {
        $this->middleware('jwt', ['only' => 'notify']);
        $this->customApiResponse = $customResponse;
    }

    public function send()
    {
        // Reads the variables sent via POST from our gateway
        $sessionId   = request('sessionId');
        $serviceCode = request('serviceCode');
        $phoneNumber = request('phoneNumber');
        $text        = request('text');

        // $phoneNumber = \Illuminate\Support\Str::replaceFirst('+234', '0', $phoneNumber);

        if ($text == "") {
            $response = "END Sorry you are not registered for this service.";
            // This is the first request. Note how we start the response with CON
            // if (!User::where('phonenumber', $phoneNumber)->exists()) {
            //     $response = "END Sorry you are not registered for this service.";
            // } 
            // $user =  User::where('phonenumber', $phoneNumber)->first();
            // $emergencyContacts =  Emergencycontacts::collection($user->emergencycontacts);
            // foreach ($emergencyContacts as $contact) {
            //     Mail::to($contact)->send(new EmergencyMail($contact->name));
            //     //send sms
            //     $this->sendSMS($user->name, \Illuminate\Support\Str::replaceFirst('0', '+234', $contact->phonenumber));
            // }

            // $response = "END {$phoneNumber} SMS and Email has been sent to your registered emergency contacts.\n";
        }

        // header('Content-type: text/plain');
        // echo $response;
        // // Echo the response back to the API
        return response($response)
            ->header('Content-Type', 'text/plain');
    }

    public function notify()
    {
        $user = auth()->user();
        $emergencyContacts =  Emergencycontacts::collection($user->emergencycontacts);

        if (!$emergencyContacts) {
            return $this->customApiResponse()->errorBadRequest('no emergency contact registered');
        }

        try {
            $userLocation = resolve('App\Services\GeolocationService')->getUserLocation();

            foreach ($emergencyContacts as $contact) {
                Mail::to($contact)->send(new EmergencyMail($contact->name, $userLocation));
                $contact->phonenumber = \Illuminate\Support\Str::replaceFirst('0', '+234', $contact->phonenumber);
                // $smsService = resolve('App\Services\SMSservice')->sendSMS($user->name, $contact->phonenumber);
            }
        } catch (\Exception $e) {
            return $this->customApiResponse->errorInternal('could not connect to host, please try again later');
        }

        return $this->customApiResponse->okay('sms and email sent to emergency contacts');
    }

    public function sendSMS($username, $recepient)
    {
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

            // print_r($result);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return true;
    }
}

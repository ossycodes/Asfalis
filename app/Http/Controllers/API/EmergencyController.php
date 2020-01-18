<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Jobs\ProcessSMS;
use App\Mail\EmergencyMail;
use Illuminate\Http\Request;
use App\Jobs\ProcessEmergencyEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use AfricasTalking\SDK\AfricasTalking;
use App\Http\Requests\EmergencyRequest;
use App\Http\Resources\Emergencycontacts;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\ProcessNotifyEmergencyagenciesViaTwitter;
use App\Repositories\Contracts\UserRepositoryInterface;

class EmergencyController extends Controller
{
    public $customResponse;
    public $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('jwt', ['only' => 'notify']);
        $this->userRepo = $userRepo;
    }

    // public function ussd()
    // {
    //     // Reads the variables sent via POST from our gateway
    //     $sessionId   = request('sessionId');
    //     $serviceCode = request('serviceCode');
    //     $phoneNumber = request('phoneNumber');
    //     $text        = request('text');

    //     if ($text == "") {
    //         // This is the first request. Note how we start the response with CON
    //         $response  = "CON Welcome to StaySafe please enter password for {$phoneNumber} \n";
    //     } else if ($text) {
    //         $response = "END Your password is " . $text;

    //         // $response = "END Enter your location";

    //         //TODO: ask user for location and pass to ProcessEmergencyEmail/ProcessSMS
    //         // $location

    //         $user = $this->userRepo->getUserWithPhonenumberAndPassword($phoneNumber, $text);

    //         if ($user) {

    //             //send sms in background.
    //             // ProcessSMS::dispatch($user, $location);
    //             //send email in background? maybe.
    //             // ProcessEmergencyEmail::dispatch($user,$location);
    //             ProcessEmergencyEmail::dispatch($user);
    //             $response = "END SMS and Email has been sent to your registered emergency contacts, we have also tweeted various emergency agencies.\n";
    //         } else {

    //             $response = "END You are not registered for this service, please download Usecured application. \n";
    //         }
    //     }

    //     // Echo the response back to the API
    //     return response($response)
    //         ->header('Content-Type', 'text/plain');
    // }

    public function ussd()
    {
        // Reads the variables sent via POST from our gateway
        $sessionId   = $_POST["sessionId"];
        $serviceCode = $_POST["serviceCode"];
        $phoneNumber = $_POST["phoneNumber"];
        $text        = $_POST["text"];

        if ($text == "") {
            // This is the first request. Note how we start the response with CON
            $response  = "CON Welcome to BESAFE what is your emergency situation? \n";
            $response .= "1. Fire Service \n";
            $response .= "2. Road Accident \n";
            $response .= "3. Arm Robbery \n";
            $response .= "4. Others \n";
        } else if ($text == "1") {
            $response = "CON Please enter your location \n";
        } else if ($text == "2") {
            $response = "CON Please enter your location \n";
        } else if ($text == "3") {
            $response = "CON Please enter your location \n";
        } else if ($text == "4") {
            $response = "CON Please enter your location \n";
        } else if ($text) {

            $user = $this->userRepo->getUserWithPhonenumber($phoneNumber);

            if ($user) {
                $response = "END SMS and Email has been sent to your registered In Case Of Emergency (I.C.E) contacts, we have also tweeted various emergency agencies.\n";
                //dispatch
                //send sms in background.
                //ProcessSMS::dispatch($user, $location);
                //send email in background? maybe.
                //ProcessEmergencyEmail::dispatch($user,$location);
                //notify emergency agencies via Twitter
                ProcessNotifyEmergencyagenciesViaTwitter::dispatch($text, $user);
            } else {
                $response = "END You are not registered for this service, please download StaySafeNigeria application and register an account. \n";
                //dispatch, remember to delete the below codes, was for testing
                $user = \App\User::find(1);
                ProcessNotifyEmergencyagenciesViaTwitter::dispatch($text, $user);
            }
        }

        // // Echo the response back to the API
        return response($response)
            ->header('Content-Type', 'text/plain');
    }


    public function emergency(EmergencyRequest $request)
    {
        // put in try and catch sha
        
        // 1. send SMS to I.C.E contatcs
            //send sms in background.
            // $location = resolve('App\Services\GeolocationService')->getUserLocation($latitude, $longitude);
            // ProcessSMS::dispatch($user, $location);
        
        // 2. Send I.C.E contatcs emails
            // ProcessEmergencyEmail::dispatch(auth()->user(), $location);
        
        //TODO
        //3. Notify Emergency agencies via twitter
            //ProcessNotifyEmergencyagenciesViaTwitter::dispatch($text, $user);

        return $this->okay('sms and email sent to emergency contacts');
    }
}

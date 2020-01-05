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
use App\Http\Requests\EmergencyRequest;
use App\Jobs\ProcessEmergencyEmail;
use App\Jobs\ProcessSMS;
use App\Repositories\Contracts\UserRepositoryInterface;

class EmergencyController extends Controller
{
    public $customResponse;
    public $userRepo;

    public function __construct(Customresponses $customResponse, UserRepositoryInterface $userRepo)
    {
        $this->middleware('jwt', ['only' => 'notify']);
        $this->customApiResponse = $customResponse;
        $this->userRepo = $userRepo;
    }

    public function ussd()
    {
        // Reads the variables sent via POST from our gateway
        $sessionId   = request('sessionId');
        $serviceCode = request('serviceCode');
        $phoneNumber = request('phoneNumber');
        $text        = request('text');

        if ($text == "") {
            // This is the first request. Note how we start the response with CON
            $response  = "CON Welcome to Usecured please enter password for {$phoneNumber} \n";

        } else if ($text) {
            $response = "END Your password is " . $text;
          
            //TODO: ask user for location

            $user = $this->userRepo->getUserWithPhonenumberAndPassword($phoneNumber, $text);
           
            if ($user) {
               
                //send sms in background.
                // ProcessSMS::dispatch($user);
                //send email in background? maybe.
                ProcessEmergencyEmail::dispatch($user);
               
                $response = "END SMS and Email has been sent to your registered emergency contacts.\n";
            } else {
                $response = "END You are not registered for this service, please download Usecured application. \n";
            }
        }

        // // Echo the response back to the API
        return response($response)
            ->header('Content-Type', 'text/plain');
    }


    public function emergency(EmergencyRequest $request)
    {

        // ProcessEmergencyEmail::dispatch(auth()->user());
        //Responsible for sending emergency sms via mobile application
        // $user = auth()->user();
        // $emergencyContacts = $user->emergencycontacts;
        // if ($emergencyContacts->count() === 0) {
        //     return $this->customApiResponse->errorBadRequest('no emergency contact registered');
        // }

        // $emergencyContacts =  Emergencycontacts::collection($user->emergencycontacts);

        // try {
        //     $userLocation = resolve('App\Services\GeolocationService')->getUserLocation();

        //     foreach ($emergencyContacts as $contact) {
        //         Mail::to($contact)->send(new EmergencyMail($contact->name, $userLocation));
        //         // resolve('App\Services\SMSservice')->sendSMS($user->fullName, $contact->phonenumber);
        //     }
        // } catch (\Exception $e) {
        //     return $this->customApiResponse->errorInternal('could not connect to host, please try again later');
        // }

        // return $this->customApiResponse->okay('sms and email sent to emergency contacts');
    }
}

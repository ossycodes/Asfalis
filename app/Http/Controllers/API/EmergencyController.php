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

class EmergencyController extends Controller
{
    public $customResponse;

    public function __construct(Customresponses $customResponse)
    {
        $this->middleware('jwt', ['only' => 'notify']);
        $this->customApiResponse = $customResponse;
    }

    public function ussd()
    {
        // Reads the variables sent via POST from our gateway
        // $sessionId   = request('sessionId');
        // $serviceCode = request('serviceCode');
        // $phoneNumber = request('phoneNumber');
        // $text        = request('text');

        // $phoneNumber = \Illuminate\Support\Str::replaceFirst('+234', '0', $phoneNumber);

        // if ($text == "") {
        // $response = "END {$phoneNumber} {$text}";
        // $phoneNumber = str_replace('+234', '0', '+2349023802591');
        $phoneNumber = "09023802591";
        // This is the first request. Note how we start the response with CON
        if (!User::where('phonenumber', $phoneNumber)->exists()) {
            $response = "END Sorry you are not registered for this service.";
            return response($response)
                ->header('Content-Type', 'text/plain');
        }
        $user =  User::where('phonenumber', $phoneNumber)->first(); //make use of repository pattern

        // $emergencyContacts =  Emergencycontacts::where($user->emergencycontacts)->get(); //move this to job handle method


        // //code smell, the more emergency contacts the more memory space taken (make this a job, so you can send response back to Africa's talking, and then dispacth this job after sending back the response)
        // foreach ($emergencyContacts as $contact) { //move this to job handle method
        //     Mail::to($contact)->send(new EmergencyMail($contact->name)); //move this to job handle method
        //     //send sms
        //     //$this->sendSMS($user->name, \Illuminate\Support\Str::replaceFirst('0', '+234', $contact->phonenumber));
        // }


        ProcessEmergencyEmail::dispatch($user);
        ProcessSMS::dispatch($user);

        $response = "END SMS and Email has been sent to your registered emergency contacts.\n";
        // }

        // // Echo the response back to the API
        return response($response)
            ->header('Content-Type', 'text/plain');
    }

    public function emergency(EmergencyRequest $request)
    {
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

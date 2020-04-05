<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use Twilio\TwiML\VoiceResponse;

class IncomingEmergencyCallController extends Controller
{
    public $userRepo;
    public $user;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function handleIncomingCall()
    {
        $response = new VoiceResponse();

        $gather = $response->gather([
            'action' => secure_url('/api/v1/incomingemergencycall/action'),
            'numDigits' => 1
        ]);

        // $this->user = $this->userRepo->findByPhonenumber(request()->input('From'));
        
        $this->user = "Sheriff";

        if (!$this->user) {
            $response->say("You are not registered for this service, please download Asfalis mobile application from playstore and register. Thank you.");
            return $response;
        }

        $gather->say("Hello {$this->user}. Welcome to Asfalis.");

        $gather->say("Press 1 to speak to a fire service agent");
        $gather->say("Press 2 for Road accident");
        $gather->say("Press 3 to speak to a NEMA agent");
        $gather->say("Press 4 for Armed Robbery");
        $gather->say("Press 5 for Covid19");

        $response->redirect(secure_url('api/v1/incomingemergencycall'));

        return $response;
    }

    public function handleUserInput()
    {
        $response = new VoiceResponse();
        $userInput = request()->input("Digits");

        if (isset($userInput)) {
            switch ($userInput) {
                case 1:
                    $response->say('connecting you to a fire service agent behind the scene!');
                    // $response->dial("08038xxxxxxx"); //third-party phonenumbe here
                    break;
                case 2:
                    $response->say('connecting you to a Road safety service agent behind the scene!');
                    // $response->dial("08038xxxxxxx"); //third-party phonenumbe here
                    break;
                case 3:
                    $response->say('connecting you to a Nema emergency agent behind the scene!');
                    // $response->dial("08038xxxxxxx"); //third-party phonenumbe here
                    break;
                case 4:
                    $response->say('connecting you to a Police officer behind the scene!');
                    // $response->dial("08038xxxxxxx"); //third-party phonenumbe here
                    break;
                case 5:
                    $response->say('connecting you to a medical proffesional behind the scene!');
                    // $response->dial("08038xxxxxxx"); //third-party phonenumbe here
                    break;
                default:
                    $response->say("Sorry, {$this->user}. You can only press between 1 to 5.");
                    break;
            }
        }

        return $response;
    }
}

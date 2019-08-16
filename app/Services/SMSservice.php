<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Filesystem\Filesystem;

class SMSservice
{
    protected $client;
    protected $publicKey;
    protected $accessToken;
    protected $messageID;

    const BASEURL = "https://jusibe.com/smsapi/";

    public function __construct()
    {
        $this->publicKey = config('services.sms.publickey');
        $this->accessToken = config('services.sms.accessToken');
        $this->initializeClient();
        // $this->client = new Client(['base_uri' => self::BASEURL]);
    }

    /**
     * Instantiate Guzzle Client and prepare request for http operations
     * @return none
     */
    private function initializeClient()
    {
        $this->client = new Client(['base_uri' => self::BASEURL]);
    }



    public function sendSMS($username, $emergencyContactPhonenumber)
    {

        $data =  [
            'to' => $emergencyContactPhonenumber,
            'from' => 'USECURED',
            'message' => "Hi {$username} is in an emergency situation and currently needs your help"
        ];

        $this->response = $this->client->request('POST', 'send_sms', [
            'auth' => [$this->publicKey, $this->accessToken],
            'form_params' => $data
        ]);

        $this->messageID = $this->getResponse()->message_id;

        if($this->checkDeliveryStatus()) {
            return true;
        }
         return false;   


        // $recepient = \Illuminate\Support\Str::replaceFirst('0', '+234', $recepients->phonenumber);
        // $AT = resolve(AfricasTalking::class);
        // $sms = $AT->sms();
        // $message = "Hi {$username} is in an emergency situation and currently needs your help";
        // $from = "USECURED";

        // try {
        //     $result = $sms->send([
        //         'to' => $recepient,
        //         'message' => $message,
        //         'from' => $from
        //     ]);

        //     return true;
        //     // print_r($result);

        // } catch (Exception $e) {
        //     // return $e->getMessage();
        //     return false;
        // }

        // return true;

    }

    public function checkSMSCredit()
    {
        //working
        $this->response = $this->client->request('GET', 'get_credits/', [
            'auth' => [$this->publicKey, $this->accessToken],
        ]);

        return $this->getResponse();
    }

    public function checkDeliveryStatus()
    {
        //working
        $this->response = $this->client->request('GET', "delivery_status?message_id={$this->messageID}", [
            'auth' => [$this->publicKey, $this->accessToken]
        ]);

        if ($this->getResponse()->status === 'Delivered') {
            return true;
        }
        return false;
    }


    /**
     * Return the response object of any operation
     * @return object
     */
    public function getResponse()
    {
        return json_decode($this->response->getBody());
    }
}

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

    public function __construct()
    {
        $this->smsUsername = "Usecured"; //config('services.sms.username');
        $this->smsPassword =  "08027332873"; //config('services.sms.pass');
    }



    public function sendSMS($username, $emergencyContactPhonenumbers)
    {
        // dd($this->smsUsername, $this->smsPassword);
        $emergencyContactPhonenumbers = implode(",", $emergencyContactPhonenumbers);
        $emergencyMessage = "Hi {$username} is in an emergency situation and currently needs your help";
        $url = "http://www.smsdepot.com.ng/sendsms.php?user={$this->smsUsername}&password={$this->smsPassword}&mobile={$emergencyContactPhonenumbers}&message={$emergencyMessage}&senderid=USECURED";
        
        // ?user=omomeji&password=123456&mobile=08012345678,080xxxxxxxx&group_id=1,2&senderid=King Adu&message=hi, happy birthday!&unicode=1&schedule=
        $client = new Client();
        if(!app()->isLocal()) {
            $res = $client->request('POST', $url);
        }
        dump($res->getStatusCode());

        return true;

        // $this->messageID = $this->getResponse()->message_id;

        // if($this->checkDeliveryStatus()) {
        //     return true;
        // }
        //  return false;   


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

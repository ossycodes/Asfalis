<?php

namespace App\Components\Sms\Drivers;


class BulkSmsDriver extends Driver
{
    /**
     * The Nexmo client.
     * 
     * @var 
     */
    // protected $client;
    /**
     * The phone number this sms should be sent from.
     *
     * @var string
     */
    // protected $from;


    /**
     * Create a new Nexmo driver instance.
     *
     * @param    $nexmo
     * @param  string  $from
     * @return void
     */
    public function __construct($from)
    {
        $this->from = $from;
        // smsUsername
        // password
        // emergencyPhonenumbers
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        dump("sending SMS via Bulksms driver ....");
        dump([
            'from' => $this->from,
            'to' => $this->recipient,
            'text' => trim($this->message)
        ]);
        // $emergencyContactPhonenumbers = implode(",", $emergencyContactPhonenumbers);
        // $emergencyMessage = "Hi {$this->username} is in an emergency situation and currently needs your help";
        // $url = "http://www.smsdepot.com.ng/sendsms.php?user={$this->smsUsername}&password={$this->smsPassword}&mobile={$this->emergencyContactPhonenumbers}&message={$emergencyMessage}&senderid=USECURED";

        // $client = new Client();
        // if(!app()->isLocal()) {
        //     $res = $client->request('POST', $url);
        // }
        // dump($res->getStatusCode());

        // return true;
    }
}

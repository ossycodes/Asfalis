<?php

namespace App\Components\Sms\Drivers;

class AfricastalkingDriver
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

    public function __construct()
    {
        // $this->client = $nexmo;
        // $this->from = $from;
    }
    /**
     * {@inheritdoc}
     */
    public function send()
    {
        dd("sending via Africastalking driver ....");
        // return $this->client->message()->send([
        //     'type' => 'text',
        //     'from' => $this->from,
        //     'to' => $this->recipient,
        //     'text' => trim($this->message)
        // ]);
    }
}

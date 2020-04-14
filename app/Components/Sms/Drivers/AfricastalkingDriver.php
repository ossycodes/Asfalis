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

    public function __construct($AT, $from)
    {
        $this->client = $AT;
        $this->from = $from;
    }
    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $result   = $this->client->sms()->send([
            'to'      => $this->from,
            'message' => trim($this->message)
        ]);

        return $result;
    }
}

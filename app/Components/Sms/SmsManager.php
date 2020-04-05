<?php

namespace App\Components\Sms;

use Illuminate\Support\Manager;
use Twilio\Rest\Client as TwilioClient;
use App\Components\Sms\Drivers\TwilioDriver;
use App\Components\Sms\Drivers\BulkSmsDriver;
use App\Components\Sms\Drivers\AfricastalkingDriver;


class SmsManager extends Manager
{
    /**
     * Get the default SMS driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['sms.default'] ?? 'Twilio';
    }

    /**
     * Get a driver instance.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function channel($name = null)
    {
        return $this->driver($name);
    }

    /**
     * Create a Twilio SMS driver instance.
     *
     * @return \App\Components\Sms\Drivers\TwilioDriver
     */
    public function createTwilioDriver()
    {
        return new TwilioDriver(
            $this->createTwilioClient(),
            config('asfalis.twillo.from')
        );
    }

    /**
     * Create the Twilio client.
     * 
     * @return \Twilio\Rest\Client
    */
    protected function createTwilioClient()
    {
        return new TwilioClient(
            config('asfalis.twillo.key'),
            config('asfalis.twillo.secret')
        );
    }


    /**
     * Create a Africastalking SMS driver instance.
     *
     * @return \App\Components\Sms\Drivers\AfricastalkingDriver
     */
    public function createAfricastalkingDriver()
    {
        return new AfricastalkingDriver(
            // $this->createNexmoClient(),
            // $this->app['config']['sms.nexmo.from']
        );
    }

    /**
     * Create a BulkSms SMS driver instance.
     *
     * @return \App\Components\Sms\Drivers\BulkSmsDriver
     */
    public function createBulkSmsDriver()
    {
        return new BulkSmsDriver(
            "USECURED CHANGED TO STAY SAFE"
            // $this->createTwilioClient(),
            // $this->app['config']['sms.twilio.from']
        );
    }
}

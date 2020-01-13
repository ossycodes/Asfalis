<?php

return [
    'sms' => [

        'twilio' => [
            'from' => env('TWILIO_FROM'),
            'key' => env('TWILIO_ACCOUNT_SID'),
            'secret' => env('TWILIO_AUTH_TOKEN')
        ],
    ]

];

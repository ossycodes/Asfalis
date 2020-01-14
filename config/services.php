<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'africastalking' => [
        'apiKey' => env('SMS_APIKEY'),
        'username' => env('SMS_USERNAME'),
    ],

    'sms' => [
        'publickey' => env('PUBLIC_KEY'),
        'accessToken' => env('ACCESS_TOKEN'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'geocoder' => [
        'key' => env('GEOCODER_KEY')
    ],

    'twitter' => [
        'consumer_key'    => env('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
        'access_token'    => env('TWITTER_ACCESS_TOKEN'),
        'access_secret'   => env('TWITTER_ACCESS_SECRET')
    ],

    'emergencyagenciestwitterhandles' => [
        'ncc' => '@NgComCommission',
        'nema' => '@nemanigeria',
        // 'PPRO' => '@ElkanaBala',
        // 'WellbeingFoundation' => '@wellbeingafrica',
        // 'icm' => '@world_midwives',
        // 'nigerianpoliceforce' => '@PoliceNG',
        // 'FRSC' => '@FRSCNigeria',
        // 'FMHDSD' => '@FMHDSD',
        // 'WHO' => "@WHONigeria",
        // "UNICEF" => '@UNICEF_Nigeria',
        // "ActionAgainstHungerNigeria" => '@ACF_Nigeria',
        // 'OUWaTERCenter' => "@OUWaTERCenter" //water and sanitation
    ],

];

<?php

namespace App\Services;

use GuzzleHttp\Client;


class GeolocationService
{
    public $client;

    public function __construct(Client $client)
    {
        $this->client =  $client;
        $this->key = config('services.geocoder.key');
    }

    public function getUserLocation()
    {
        $query = request()->query('q');

        $response = $this->client->request('GET', "https://api.opencagedata.com/geocode/v1/json?q={$query}&key={$this->key}");

        $body = json_decode($response->getBody());

        return $body->results[0]->formatted;
    }
}

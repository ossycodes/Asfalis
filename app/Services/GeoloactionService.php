<?php

namespace App\Services;

use GuzzleHttp\Client;

class GeolocationService
{
    public $client;
    protected $apiKey;

    public function __construct(Client $client)
    {
        $this->client =  $client;
        $this->apiKey = config('services.geocoder.key');
    }
    
    public function getUserLocation()
    {
        $latitude = request('lattitude');
        $longitude = request('longitude');
        $query = "{$latitude }+{$longitude}";
      
        $response = $this->client->request('GET', "https://api.opencagedata.com/geocode/v1/json?q={$query}&key={$this->apiKey}");

        $body = json_decode($response->getBody());

        return $body->results[0]->formatted;
    }
}

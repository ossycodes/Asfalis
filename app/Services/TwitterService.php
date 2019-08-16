<?php

namespace App\Services;

class TwitterService
{ 
    public $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    //MAKE your http guzzle request in any method here
}

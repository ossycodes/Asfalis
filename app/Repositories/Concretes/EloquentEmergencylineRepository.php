<?php

namespace App\Repositories\Concretes;

use App\Http\Resources\Emergencyline;
use App\Emergencyline as EmergencyAgency;
use App\Http\Resources\EmergencylineCollection;
use App\Repositories\Contracts\EmergencylineInterface;

class EloquentEmergencylineRepository implements EmergencylineInterface
{
    public function getAllEmergencyAgencies()
    {
        // return Emergencyline::collection(EmergencyAgency::all());
        return new EmergencylineCollection(EmergencyAgency::all());
    }
}

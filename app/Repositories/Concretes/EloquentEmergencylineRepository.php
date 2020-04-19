<?php

namespace App\Repositories\Concretes;

use App\Http\Resources\Emergencyline;
use App\Emergencyline as EmergencyAgency;
use App\Http\Resources\EmergencylineCollection;
use App\Repositories\Contracts\EmergencylineInterface;

class EloquentEmergencylineRepository implements EmergencylineInterface
{
    /**
     * fetches all emergencyagencies resource.
     *
     * @return \App\Http\Resources\EmergencylineCollection
     */
    public function getAllEmergencyAgencies()
    {
        return new EmergencylineCollection(EmergencyAgency::all());
    }

    /**
     * counts all emergencyagencies resource.
     *
     * @return integer
     */
    public function count()
    {
        return EmergencyAgency::count();
    }
}

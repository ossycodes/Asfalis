<?php

namespace App\Repositories\Contracts;

use App\Http\Resources\Emergencycontacts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\Resource;

interface EmergencyContactsRepositoryInterface

{
    public function getEmergencyContactsForAuthenticatedUser();

    public function getEmergencyContact($emergencyContactId);

    public function updateEmergencyContact($emergencyContact);

    public function getAuthenticatedUserEmergencyContactsCount();
}

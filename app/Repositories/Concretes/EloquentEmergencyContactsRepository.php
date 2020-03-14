<?php

namespace App\Repositories\Concretes;

use App\Emergencycontacts as AppEmergencycontacts;
use App\Http\Resources\Emergencycontacts;
use App\Http\Resources\EmergencycontactsCollection;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\EmergencyContactsRepositoryInterface;
use Illuminate\Http\Resources\Json\Resource;

class EloquentEmergencyContactsRepository implements EmergencyContactsRepositoryInterface
{
    public function getEmergencyContactsForAuthenticatedUser()
    {
        return new EmergencycontactsCollection(auth()->user()->emergencycontacts);
    }

    protected function fetchEmergencyContact($emergencyContactId)
    {
        return AppEmergencycontacts::find($emergencyContactId);;
    }

    public function getEmergencyContact($emergencyContactId)
    {
        $emergencyContactId = $this->fetchEmergencyContact($emergencyContactId);
        return new Emergencycontacts($emergencyContactId);
    }

    public function createEmergencyContacts()
    {
        $emergencyContacts = request()->input("data.attributes");
        return auth()->user()->emergencycontacts()->createMany($emergencyContacts);
    }

    public function updateEmergencyContact($emergencyContactId)
    {
        $emergencyContact = $this->fetchEmergencyContact($emergencyContactId);
        return $emergencyContact->update([
            "name" => request()->input('data.attributes.name'),
            "email" => request()->input('data.attributes.email'),
            "phonenumber" => request()->input('data.attributes.phonenumber'),
        ]);
    }

    public function deleteEmergencyContact($emergencyContactId)
    {
        $emergencyContact = $this->fetchEmergencyContact($emergencyContactId);
        return $emergencyContact->delete();
    }

    public function getAuthenticatedUserEmergencyContactsCount()
    {
        return auth()->user()->emergencycontacts()->count();
    }
}

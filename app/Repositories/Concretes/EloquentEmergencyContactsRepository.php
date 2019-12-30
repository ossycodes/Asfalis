<?php

namespace App\Repositories\Concretes;

use App\Emergencycontacts as AppEmergencycontacts;
use App\Http\Resources\Emergencycontacts;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\EmergencyContactsRepositoryInterface;
use Illuminate\Http\Resources\Json\Resource;

class EloquentEmergencyContactsRepository implements EmergencyContactsRepositoryInterface
{
    public function getEmergencyContactsForAuthenticatedUser(): Collection
    {
        return auth()->user()->emergencycontacts;
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
        foreach (request()->all() as $emergencyContacts => $contacts) {
            foreach ($contacts as $contact) {
                return auth()->user()->emergencycontacts()->create($contact);
            }
        }
    }

    public function updateEmergencyContact($emergencyContactId)
    {
        $emergencyContact = $this->fetchEmergencyContact($emergencyContactId);
        return $emergencyContact->update(request()->all());
    }

    public function deleteEmergencyContact($emergencyContactId)
    {
        $emergencyContact = $this->fetchEmergencyContact($emergencyContactId);
        return $emergencyContact->delete();
    }
}

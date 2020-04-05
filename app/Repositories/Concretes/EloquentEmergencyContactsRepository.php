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
    /**
     * fetches all registered I.C.E contacts.
     *
     * @return \App\Http\Resources\EmergencycontactsCollection
     */
    public function getEmergencyContactsForAuthenticatedUser()
    {
        return new EmergencycontactsCollection(auth()->user()->emergencycontacts);
    }

    /**
     * fetch emergencycontact by the given ID
     *
     * @param  $emergencyContactId
     * @return \App\Emergencycontacts
     */
    protected function fetchEmergencyContact($emergencyContactId)
    {
        return AppEmergencycontacts::find($emergencyContactId);;
    }

    /**
     * fetch emergencycontact by the given ID
     *
     * @param  $emergencyContactId
     * @return \App\Http\Resources\Emergencycontacts
     */
    public function getEmergencyContact($emergencyContactId)
    {
        $emergencyContactId = $this->fetchEmergencyContact($emergencyContactId);
        return new Emergencycontacts($emergencyContactId);
    }

    /**
     * creates I.C.E contacts for the authenticated user.
     * 
     * @return 
     */
    public function createEmergencyContacts()
    {
        $emergencyContacts = request()->input("data.attributes");
        return auth()->user()->emergencycontacts()->createMany($emergencyContacts);
    }

     /**
     * updates emergencycontact by the given ID
     *
     * @param  $emergencyContactId
     * @return \App\Emergencycontacts
     */
    public function updateEmergencyContact($emergencyContactId)
    {
        $emergencyContact = $this->fetchEmergencyContact($emergencyContactId);
        return $emergencyContact->update([
            "name" => request()->input('data.attributes.name'),
            "email" => request()->input('data.attributes.email'),
            "phonenumber" => request()->input('data.attributes.phonenumber'),
        ]);
    }

     /**
     * deletes an emergencycontact by the given ID
     *
     * @param  $emergencyContactId
     * @return \App\Emergencycontacts
     */
    public function deleteEmergencyContact($emergencyContactId)
    {
        $emergencyContact = $this->fetchEmergencyContact($emergencyContactId);
        return $emergencyContact->delete();
    }

     /**
     * get the emergencycontact count for the authenticated user
     *
     * @return \App\Emergencycontacts
     */
    public function getAuthenticatedUserEmergencyContactsCount()
    {
        return auth()->user()->emergencycontacts()->count();
    }
}

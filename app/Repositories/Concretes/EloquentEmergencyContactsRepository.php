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
        // return Emergencycontacts::collection(auth()->user()->emergencycontacts);
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
        //omo work on this brah
        //expecting the attributes to be stored in data.attributes
        //add location in response header

        // $book = Book::create([
        // 'title' => $request->input('data.attributes.title'),
        // 'description' => $request->input('data.attributes.
        // description'),
        // 'publication_year' => $request->input('data.attributes.
        // publication_year'),
        // ]);
        // return (new BooksResource($book))
        // ->response()
        // ->header('Location', route('books.show', [
        // 'book' => $book,
        // ]));

        $emergencyContacts = request()->toArray()["emergencycontacts"];
        return auth()->user()->emergencycontacts()->createMany($emergencyContacts);

        //fvck me, refactored from this unneccessary looping below to the above use of createMany

        // foreach (request()->all() as $emergencyContacts => $contacts) {
        //     foreach ($contacts as $contact) {
        //          return auth()->user()->emergencycontacts()->create($contact);
        //     }
        // }
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

    public function getAuthenticatedUserEmergencyContactsCount()
    {
        return auth()->user()->emergencycontacts()->count();
    }
}

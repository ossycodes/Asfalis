<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\User;
use Illuminate\Http\Request;
use  App\Http\Resources\Emergencycontacts;
use App\Http\Requests\UpdateEmergencyContacts;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\RegisterEmergencycontacts;
use App\Repositories\Contracts\EmergencyContactsRepositoryInterface;

class EmergencycontactsController extends \App\Http\Controllers\Controller
{
    public $customResponse;

    public function __construct(EmergencyContactsRepositoryInterface $emergencyContactsRepositoryInterface)
    {
        $this->middleware('jwt');
        $this->EmergencyContactsRepo = $emergencyContactsRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithData($this->EmergencyContactsRepo->getEmergencyContactsForAuthenticatedUser());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterEmergencycontacts $request)
    {
        $emergencyContactsCount = $this->EmergencyContactsRepo->getAuthenticatedUserEmergencyContactsCount();
        if ($emergencyContactsCount === 2 && count(request()->contacts) === 2) {
            return $this->errorBadRequest('only 3 emergency contacts can be registered');
        }
        if ($emergencyContactsCount === 3) {
            return $this->errorBadRequest('maximum number of emergency contacts registered');
        }
        $this->EmergencyContactsRepo->createEmergencyContacts();
        return $this->created("emergencycontacts created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emergencycontacts  $emergencycontacts
     * @return \Illuminate\Http\Response
     */
    public function show($emergencyContactId)
    {
        return $this->respondWithData($this->EmergencyContactsRepo->getEmergencyContact($emergencyContactId));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emergencycontacts  $emergencycontacts
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmergencyContacts $request, $emergencyContactId)
    {
        $this->EmergencyContactsRepo->updateEmergencyContact($emergencyContactId);
        return $this->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emergencycontacts  $emergencycontacts
     * @return \Illuminate\Http\Response
     */
    public function destroy($emergencycontactId)
    {
        $this->EmergencyContactsRepo->deleteEmergencyContact($emergencycontactId);
        return $this->noContent();
    }
}

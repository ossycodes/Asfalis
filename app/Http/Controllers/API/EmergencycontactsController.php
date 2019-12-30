<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\User;
use Illuminate\Http\Request;
use App\Helpers\Customresponses;
use  App\Http\Resources\Emergencycontacts;
use App\Http\Requests\UpdateEmergencyContacts;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\RegisterEmergencycontacts;
use App\Repositories\Contracts\EmergencyContactsRepositoryInterface;

class EmergencycontactsController extends \App\Http\Controllers\Controller
{
    public $customResponse;

    public function __construct(Customresponses $customResponse, EmergencyContactsRepositoryInterface $emergencyContactsRepositoryInterface)
    {
        $this->middleware('jwt');
        $this->customApiResponse = $customResponse;
        $this->EmergencyContactsRepo = $emergencyContactsRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Emergencycontacts::collection($this->EmergencyContactsRepo->getEmergencyContactsForAuthenticatedUser());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterEmergencycontacts $request)
    {
        $emergencyContactsCount = auth()->user()->emergencycontacts()->count();
        if ($emergencyContactsCount === 2 && count(request()->contacts) === 2) {
            return $this->customApiResponse->errorBadRequest('only 3 emergency contacts can be registered');
        }
        if ($emergencyContactsCount === 3) {
            return $this->customApiResponse->errorBadRequest('maximum number of emergency contacts registered');
        }
        $this->EmergencyContactsRepo->createEmergencyContacts();
        return $this->customApiResponse->created("emergencycontacts created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emergencycontacts  $emergencycontacts
     * @return \Illuminate\Http\Response
     */
    public function show($emergencyContactId)
    {
        return response()->json($this->EmergencyContactsRepo->getEmergencyContact($emergencyContactId, 200));
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
        return response()->json([], Response::HTTP_NO_CONTENT);
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
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}

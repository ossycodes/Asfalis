<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\User;
use Illuminate\Http\Request;
use  App\Http\Resources\Emergencycontacts;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\RegisterEmergencycontacts;

class EmergencycontactsController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Emergencycontacts::collection(auth()->user()->emergencycontacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterEmergencycontacts $request)
    {
        if (auth()->user()->emergencycontacts()->count() === 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'maximum number of emergency contacts registered',
            ], 400);
        }
        $emergencycontact = auth()->user()->emergencycontacts()->create(request()->all());
        return new Emergencycontacts($emergencycontact);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emergencycontacts  $emergencycontacts
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Emergencycontacts $emergencycontacts)
    {
        return response()->json(new Emergencycontacts($emergencycontacts), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emergencycontacts  $emergencycontacts
     * @return \Illuminate\Http\Response
     */
    public function update(RegisterEmergencycontacts $request, \App\Emergencycontacts $emergencycontacts)
    {
        $emergencycontacts->update(request()->all());
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emergencycontacts  $emergencycontacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Emergencycontacts $emergencycontacts)
    {
        $emergencycontacts->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}

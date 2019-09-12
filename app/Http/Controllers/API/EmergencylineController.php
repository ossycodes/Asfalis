<?php

namespace App\Http\Controllers\API;

use App\Emergencyline as Emergencylines;
use App\Http\Resources\Emergencyline;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmergencylineController extends  \App\Http\Controllers\Controller
{
    public function index()
    {
        return response()->json(Emergencyline::collection(Emergencylines::all()), Response::HTTP_OK);
    }
}

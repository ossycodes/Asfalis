<?php

namespace App\Http\Controllers\API\Admin;

use App\Emergencyline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmergencylineCollection;
use App\Http\Resources\Emergencyline as EmergencylineResource;

class EmergencylinesController extends Controller
{
    public function index()
    {
        return new EmergencylineCollection(Emergencyline::all());
    }

    public function store(Request $request)
    {
        $emergencyline = Emergencyline::create($request->input("data.attributes"));
        return (new EmergencylineResource($emergencyline))
            ->response()
            ->header('Location', route('emergencyline.show', ['id' =>
            $emergencyline->id]));
    }

    public function show($id)
    {
        $emergencyline = Emergencyline::find($id);
        return new EmergencylineResource($emergencyline);
    }

    public function update(Request $request, $id)
    {
        //in your rules, create a custom rule, that ensures the id
        //given in the url, macthes the id given in the body
        Emergencyline::where('id', $id)
            ->update($request->input('data.attributes'));
        $emergencyline = Emergencyline::find($id);
        return new EmergencylineResource($emergencyline);
    }

    public function destroy($id)
    {
        $emergencyline = Emergencyline::find($id);
        $emergencyline->delete();
        return response(null, 204);
    }
}

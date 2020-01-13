<?php

namespace App\Http\Controllers\API\Admin;

use App\Tips;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTipsRequest;
use App\Http\Requests\UpdateTipsRequest;
use App\Http\Resources\TipsResource;
use App\Http\Resources\TipsCollection;

class TipsController extends Controller
{
    public function index()
    {
        return new TipsCollection(Tips::all());
    }

    public function show($id)
    {
        $tips = Tips::find($id);
        return new TipsResource($tips);
    }

    public function update(UpdateTipsRequest $request,  $id)
    {
        //in your rules, create a custom rule, that ensures the id
        //given in the url, macthes the id given in the body
        Tips::where('id', $id)
            ->update($request->input('data.attributes'));
        $tips = Tips::find($id);
        return new TipsResource($tips);
    }

    public function store(CreateTipsRequest $request)
    {
        $tip = Tips::create($request->input('data.attributes'));
        return (new TipsResource($tip))
            ->response()
            ->header('Location', route('tip.show', ['id' =>
            $tip->id]));
    }

    public function destroy($id)
    {
        $tips = Tips::find($id);
        $tips->delete();
        return response(null, 204);
    }
}

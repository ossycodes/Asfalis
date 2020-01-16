<?php

namespace App\Http\Controllers\API;

use App\Tips;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipsResource;
use App\Http\Resources\TipsCollection;

class TipsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('')
    // }

    public function index()
    {
        return new TipsCollection(Tips::all());
    }

    public function show($id)
    {
        $tips = Tips::find($id);
        return new TipsResource($tips);
    }
}

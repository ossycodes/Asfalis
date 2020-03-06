<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\StoreIssues;
use App\Http\Controllers\Controller;
use App\Http\Resources\IssuesCollection;

class IssuesController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');    
    }

    public function index()
    {
        return new IssuesCollection(auth()->user()->issues);
    }

    public function store(StoreIssues $request)
    {
        $body = $request->validated()["data"]["attributes"];
        \App\Issue::create([
            "description" => $body["description"],
            "location" => $body["location"],
            "user_id" => auth()->id()
        ]);

        return $this->okay("Issue sent to the appropraite emergency agency (LASEMA)");
    }
}

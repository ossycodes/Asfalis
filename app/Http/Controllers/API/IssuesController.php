<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\StoreIssues;
use App\Http\Controllers\Controller;

class IssuesController extends Controller
{
    public function store(StoreIssues $request)
    {
        $body = $request->validated()["data"]["attributes"];
        \App\Issue::create([
            "description" => $body["description"],
            "location" => $body["location"],
            "user_id" => auth()->id()
        ]);

        return $this->okay("Issue sent to the appropraite emergency agencies");
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class UserTipsController extends Controller
{
    public function index()
    {
        return auth()->user()->tips();
    }
}

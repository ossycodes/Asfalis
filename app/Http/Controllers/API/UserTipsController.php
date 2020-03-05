<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTipsController extends Controller
{
    public function index()
    {
        return auth()->user()->tips();
    }
}

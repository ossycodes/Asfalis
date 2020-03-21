<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserEmergencyContactsController extends Controller
{
    public function index()
    {
        //put this in a repostory and then in a resource class
        return auth()->user()->emergencycontacts;
    }
}

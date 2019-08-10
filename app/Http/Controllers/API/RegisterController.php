<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUser;

class RegisterController extends \App\Http\Controllers\Controller
{
    public function store(RegisterUser $request)
    {
        User::create(request()->except('password_confirmation'));
        
        if (!$token = auth()->attempt(request()->only(['email', 'password']))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

}

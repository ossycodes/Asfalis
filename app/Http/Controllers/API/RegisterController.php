<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUser;
use App\Http\Resources\User as AppUser;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends \App\Http\Controllers\Controller
{
   
    public function store(RegisterUser $request, User $user)
    {
        if ($user->register()) {
            return response()->json([
                'message' => 'registeration successful, password as been sent to your email'
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'error' => 'something went wrong'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

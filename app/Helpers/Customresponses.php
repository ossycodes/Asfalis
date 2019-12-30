<?php

namespace App\Helpers;

use App\Http\Resources\User;
use Symfony\Component\HttpFoundation\Response;

//refactor to be a trait to avoid passing it all the time through
//dependency injection to classes that uses it's methods
//and then use it in base controller class

class Customresponses
{
    public function okay($msg = null)
    {
        return response()->json([
            'status' => true,
            'message' => $msg ?? 'okay'
        ], Response::HTTP_OK);
    }

    public function errorBadRequest($msg = null)
    {
        return response()->json([
            'status' => false,
            'error' => $msg ?? 'bad request'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => new User(auth()->user()),
        ], Response::HTTP_CREATED);
    }

    public function errorUnauthorized()
    {
        return  response()->json([
            'status' => false,
            'error' => 'Unauthorized'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function errorInternal($msg = null)
    {
        return response()->json([
            'status' => false,
            'error' => $msg ?? 'internal server error'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function created($msg = null)
    {
        return response()->json([
            'status' => true,
            'message' => $msg
        ], Response::HTTP_CREATED);
    }
}

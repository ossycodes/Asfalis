<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginUser;
use App\Http\Resources\User;

class AuthController extends  \App\Http\Controllers\Controller
{
    public $customApiResponse;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(\App\Helpers\Customresponses $customApiResponse)
    {
        $this->middleware('jwt', ['except' => ['login']]);
        $this->customApiResponse = $customApiResponse;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUser $request)
    {

        if (!$token = auth()->attempt(request(['email', 'password']))) {
            return $this->customApiResponse->errorUnauthorized();
        }
        return $this->customApiResponse->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     * won't be using since i have set the token never to expire
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *won't be using since i have set the token never to expire
     * @return \Illuminate\Http\JsonResponse
     */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }


}

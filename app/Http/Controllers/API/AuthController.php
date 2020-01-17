<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Http\Resources\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

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
        $credentials = [
            'email' => request()->input('data.attributes.email'),
            'password' => request()->input('data.attributes.password')
        ];

        if (!$token = auth()->attempt($credentials)) {
            throw new UnauthorizedException("not authenticated");
        }
        return $this->respondWithToken($token);
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
        return $this->okay('successfully logged out');
    }
}

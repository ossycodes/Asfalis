<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfile;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Updates the authenticated user details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfile $request)
    {
        auth()->user()->update(request()->all());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Get the authenticated User.
     *
     * @return \App\Http\Resources\User
     */
    public function show()
    {
        return new \App\Http\Resources\User(auth()->user());
    }
}

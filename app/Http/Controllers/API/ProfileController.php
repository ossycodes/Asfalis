<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfile;
use App\Repositories\Contracts\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public $userRepo;

    public function __construct(UserRepositoryInterface $userRepoInterface)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepoInterface;
    }

    /**
     * Updates the authenticated user details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfile $request)
    {
        //you can't update email oh!!!
        $this->userRepo->updateProfile();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Get the authenticated User.
     *
     * @return \App\Http\Resources\User
     */
    public function show()
    {
        return $this->userRepo->getAuthenticatedUser();
    }
}

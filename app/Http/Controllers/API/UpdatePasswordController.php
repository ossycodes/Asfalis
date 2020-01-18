<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UpdatePassword;
use App\Repositories\Contracts\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class UpdatePasswordController extends \App\Http\Controllers\Controller
{
    public $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('jwt');
        $this->userRepo = $userRepo;
    }

    public function update(UpdatePassword $request)
    {
        $this->userRepo->updatePassword();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Traits\userCanResetPassword;
use App\Repositories\Contracts\UserRepositoryInterface;

class ForgetPasswordController extends Controller
{
    use userCanResetPassword;
    public $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function store(ForgetPasswordRequest $request)
    {
        if (!$this->validateRequestandCreateToken()) {
            return $this->errorBadRequest('Reset password link as already been sent to user\'s email');
        }
        return $this->okay('reset password link sent successfully');
    }
}

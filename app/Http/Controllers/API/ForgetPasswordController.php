<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Traits\userCanResetPassword;
use App\Notifications\ResetPasswordNotification;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgetPasswordController extends \App\Http\Controllers\Controller
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

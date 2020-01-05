<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], ['email.exists' => 'email does not exist']);
        return $this->validateRequestandCreateToken();
    }
}

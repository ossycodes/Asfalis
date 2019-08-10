<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\userCanResetPassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgetPasswordController extends \App\Http\Controllers\Controller
{
    use userCanResetPassword;

    public function store(Request $request)
    {
        return $this->validateRequestandCreateToken();
    }
}

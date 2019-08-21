<?php

namespace App\Http\Controllers\API;

use App\Helpers\Customresponses;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\userCanResetPassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgetPasswordController extends \App\Http\Controllers\Controller
{
    use userCanResetPassword;

    public $customApiResponse;

    public function __construct(Customresponses $customApiResponse)
    {
        $this->customApiResponse = $customApiResponse;
    }

    public function store(Request $request)
    {
        // //validate request
        // $request->validate([
        //     'email' => 'required|email|exists:users,email'
        // ]);
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], ['email.exists' => 'email does not exist']);
        return $this->validateRequestandCreateToken();
    }
}

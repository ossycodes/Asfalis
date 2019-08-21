<?php

namespace App\Traits;

use App\User;
use App\Notifications\ResetPasswordNotification;

trait userCanResetPassword
{
    public function validateRequestandCreateToken()
    {
        $user = User::where('email', request('email'))->first();

        if (!$user) {
            return $this->customApiResponse->errorBadRequest('email does not exist');
            // return response()->json([
            //     'error' => 'email does not exist'
            // ], 400);
        }

        return $this->createToken($user);
    }

    public function createToken($user)
    {
        if ($user->hasResetToken()) {
            return $this->customApiResponse->errorBadRequest('reset password link has already be sent');
        }

        //todo: expire token after one hour
        //add the date the token was created with 1hour,
        //then check if it less than or equal to the current date(time)

        $token = $user->createResetToken();

        //send user an email with the password reset link
        $user->notify(new ResetPasswordNotification($token));

        return $this->customApiResponse->created('reset password link sent successfully');
    }
}

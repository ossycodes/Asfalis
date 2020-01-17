<?php

namespace App\Traits;

use App\User;
use App\Notifications\ResetPasswordNotification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait userCanResetPassword
{

    public function validateRequestandCreateToken()
    {
        $user = $this->userRepo->getUserByEmail(request('email'));
        if (!$user) {
            return $this->error('email does not exist');
        }
        return $this->createToken($user);
    }

    public function createToken($user)
    {
        if ($user->hasResetToken()) {
            return $this->errorBadRequest('reset password link has already be sent');
        }

        //todo: expire token after one hour
        //add the date the token was created with 1hour,
        //then check if it less than or equal to the current date(time)

        //create token
        $token = $user->createResetToken();

        //send user an email with the password reset link
        $user->notify(new ResetPasswordNotification($token));

    }
}

<?php

namespace App\Traits;

use App\User;
use App\Notifications\ResetPasswordNotification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait userCanResetPassword
{
    use CustomApiresponse;
    /**
     * validates and creates a reset token for user.
     *
     * @return App\User
     */
    public function validateRequestandCreateToken()
    {
        $user = $this->userRepo->getUserByEmail(request()->input('data.attributes.email'));

        if ($user->hasResetToken()) {
            return false;
        }

        $this->createToken($user);
    }

    /**
     * create password reset token for user.
     *
     * @param  User  $user
     */
    public function createToken($user)
    {
        //todo: expire token after one hour
        //add the date the token was created with 1hour,
        //then check if it less than or equal to the current date(time)

        //create token
        $token = $user->createResetToken();

        //send user an email with the password reset link
        return $user->notify(new ResetPasswordNotification($token));
    }
}

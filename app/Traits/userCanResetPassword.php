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
            return response()->json([
                'error' => 'email does not exist'
            ], 400);
        }

        return $this->createToken($user);
    }

    public function createToken($user)
    {
        if ($user->hasResetToken()) {
            return response()->json([
                'error' => 'reset password link has already be sent'
            ], 400);
        }
        
        //expire token after one hour
        $token = $user->createResetToken();

        $user->notify(new ResetPasswordNotification($token));

        return response()->json([
            'message' => 'reset password link sent successfully'
        ]);
    }
}

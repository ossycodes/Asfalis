<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUser;
use Exception;

class RegisterController extends \App\Http\Controllers\Controller
{
    public function store(RegisterUser $request, User $user)
    {
        try {
            if ($user->register()) {
                return $this->created('registeration successful, password as been sent to your email');
            }
        } catch (Exception $e) {
            return $this->errorInternal();
        }
    }
}

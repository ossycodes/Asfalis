<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUser;
use Exception;

class RegisterController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        $this->middleware("json.api.headers");
    }

    public function store(RegisterUser $request, User $user)
    {
        if ($user->register()) {
            return $this->created('registeration successful, password as been sent to your email');
        }
    }
}

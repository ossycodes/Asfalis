<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUser;
use App\Http\Resources\User as AppUser;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends \App\Http\Controllers\Controller
{
    public $customApiResponse;

    public function __construct(\App\Helpers\Customresponses $customApiResponse)
    {
        $this->customApiResponse = $customApiResponse;
    }
   
    public function store(RegisterUser $request, User $user)
    {
        if ($user->register()) {
            return $this->customApiResponse->created('registeration successful, password as been sent to your email');
        }
        return $this->customApiResponse->errorInternal();
    }
}

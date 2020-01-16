<?php

namespace App\Repositories\Concretes;

use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function getAuthenticatedUser()
    {
        return new UserResource(auth()->user());
    }

    public function updateProfile()
    {
        return auth()->user()->update(request()->all());
    }

    public function getUserByEmail($email)
    {
        return  User::where('email', $email)->first();
    }

    public function checkUserExistsViaPhonenumber($phoneNumber)
    {
        return User::where('phonenumber', $phoneNumber)->exist();
    }

    public function getUserWithPhonenumber($phoneNumber)
    {
        $formatedPhoneNumber = $this->formatPhonenumber($phoneNumber);
        return User::where('phonenumber', $formatedPhoneNumber)->first();
    }

    public function formatPhonenumber($phoneNumber)
    {
        return str_replace_first("+234", "0", $phoneNumber);
    }

    public function getUserWithPhonenumberAndPassword($phoneNumber, $password)
    {
       $user = $this->getUserWithPhonenumber($phoneNumber);
        if (Hash::check($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
    }
}

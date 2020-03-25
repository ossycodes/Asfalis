<?php

namespace App\Repositories\Concretes;

use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function find(int $id)
    {
        return User::find($id);
    }

    public function getAuthenticatedUser()
    {
        return new UserResource(auth()->user());
    }

    public function updateProfile()
    {
        return auth()->user()->update([
            "first_name" => request()->input('data.attributes.first_name'),
            "last_name" => request()->input('data.attributes.last_name'),
            "phonenumber" => request()->input('data.attributes.phonenumber'),
        ]);
    }

    public function updatePassword()
    {
        return auth()->user()->update([
            'password' => bcrypt(request()->input('data.attributes.new_password')),
            'default_password' => null
        ]);
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

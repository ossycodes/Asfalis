<?php

namespace App\Repositories\Concretes;

use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * find a user with the given ID.
     *
     * @param $phoneNumber
     * @return \App\User
     */
    public function find(int $id)
    {
        return User::find($id);
    }

    /**
     * find a user with the given phonenumber.
     *
     * @param $phoneNumber
     * @return \App\User
     */
    public function findByPhonenumber($phoneNumber)
    {
        return User::where("phonumber", $phoneNumber)->first();
    }

    /**
     * fetches the currently authenticated user as a resource.
     *
     * @return \App\Http\Resources\User
     */
    public function getAuthenticatedUser()
    {
        return new UserResource(auth()->user());
    }

    /**
     * updates the currently authenticated user profile.
     *
     * @return \App\User
     */
    public function updateProfile()
    {
        return auth()->user()->update([
            "first_name" => request()->input('data.attributes.first_name'),
            "last_name" => request()->input('data.attributes.last_name'),
            "phonenumber" => request()->input('data.attributes.phonenumber'),
        ]);
    }

    /**
     * Updates the authenticated user password.
     *
     * @return \App\User
     */
    public function updatePassword()
    {
        return auth()->user()->update([
            'password' => bcrypt(request()->input('data.attributes.new_password')),
            'default_password' => null
        ]);
    }

    /**
     * find a user by the given email.
     *
     * @param string $email
     * @return \App\User
     */
    public function getUserByEmail($email)
    {
        return  User::where('email', $email)->first();
    }

    /**
     * checks if a user with the given phonenumber exists.
     *
     * @param string $phoneNumber
     * @return boolean
     */
    public function checkUserExistsViaPhonenumber($phoneNumber)
    {
        return User::where('phonenumber', $phoneNumber)->exist();
    }

    /**
     * formats the user phonenumber and fetches the user.
     *
     * @param string $phoneNumber
     * @return \App\User
     */
    public function getUserWithPhonenumber($phoneNumber)
    {
        $formatedPhoneNumber = $this->formatPhonenumber($phoneNumber);
        return User::where('phonenumber', $formatedPhoneNumber)->first();
    }

    /**
     * formats the given phonenumber.
     *
     * @param string $phoneNumber
     * @return string
     */
    public function formatPhonenumber($phoneNumber)
    {
        return str_replace_first("+234", "0", $phoneNumber);
    }

    /**
     * gets the user with the phonenumber and password.
     *
     * @return \App\User|boolean
     */
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

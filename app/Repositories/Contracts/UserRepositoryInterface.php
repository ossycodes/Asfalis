<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface

{
    public function getAuthenticatedUser();

    public function updateProfile();

    public function getUserByEmail($email);

    public function checkUserExistsViaPhonenumber($phonenumber);

    public function getUserWithPhonenumber($phonenumber);

    public function getUserWithPhonenumberAndPassword($phonenumber, $password);
}

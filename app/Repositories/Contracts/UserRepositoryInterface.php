<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface

{
    public function find(int $id);

    public function findByPhonenumber($phonenumber);

    public function getAuthenticatedUser();

    public function updateProfile();

    public function updatePassword();

    public function getUserByEmail($email);

    public function checkUserExistsViaPhonenumber($phonenumber);

    public function getUserWithPhonenumber($phonenumber);

    public function getUserWithPhonenumberAndPassword($phonenumber, $password);
}

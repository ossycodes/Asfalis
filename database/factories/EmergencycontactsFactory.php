<?php

use App\User;
use App\Emergencycontacts;
use Faker\Generator as Faker;

$factory->define(Emergencycontacts::class, function (Faker $faker) {
    return [
        "name" => $faker->name(),
        "email" => $faker->email,
        "phonenumber" => $faker->phoneNumber,
        "user_id" => 1
    ];
});

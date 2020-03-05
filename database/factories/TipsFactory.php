<?php

use App\Tips;
use Faker\Generator as Faker;

$factory->define(Tips::class, function (Faker $faker) {
    return [
        'user_id' => App\User::pluck('id')->random(),
        'body' => $faker->sentence(),
    ];
});

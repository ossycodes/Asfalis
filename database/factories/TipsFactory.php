<?php

use App\Tips;
use Faker\Generator as Faker;

$factory->define(Tips::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence(),
    ];
});

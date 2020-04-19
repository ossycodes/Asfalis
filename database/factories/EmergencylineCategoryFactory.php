<?php

use App\EmergencylineCategory;
use Faker\Generator as Faker;

$factory->define(EmergencylineCategory::class, function (Faker $faker) {
    return [
        "name" => $faker->name()
    ];
});

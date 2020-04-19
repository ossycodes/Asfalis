<?php

use App\Emergencyline;
use Faker\Generator as Faker;

$factory->define(Emergencyline::class, function (Faker $faker) {

    return [
        'emergencylinecategory_id' => App\EmergencylineCategory::pluck('id')->random(),
        'name' => $faker->name,
        'description' => $faker->paragraph(),
        'telephone_number' => $faker->phoneNumber
    ];
});

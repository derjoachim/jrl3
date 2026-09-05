<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Route::class, function (Faker $faker) {
    return [
        'name' => $faker->text(),
        'slug' => $faker->slug,
        'user_id' => $faker->numberBetween(1, 3),
        'rating' => $faker->numberBetween(1, 5),
        'distance' => $faker->randomNumber(2, true),
        'lat_start' => $faker->optional()->latitude,
        'lon_start' => $faker->optional()->longitude,
        'lat_finish' => $faker->optional()->latitude,
        'lon_finish' => $faker->optional()->longitude,
        'description' => $faker->paragraph()
    ];
});

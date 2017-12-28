<?php

use Faker\Generator as Faker;

$factory->define(App\Workout::class, function (Faker $faker) {
    return [
        'name' => $faker->text(),
        'user_id' => $faker->numberBetween(1, 3),
        //'route_id'
        'slug' => $faker->slug,
        'date' => $faker->date,
        'time' => $faker->time,
        'time_in_seconds' => $faker->randomNumber(4),
        'finished' => $faker->boolean,
        'description' => $faker->paragraph(),
        'lon_start' => $faker->longitude,
        'lat_start' => $faker->latitude,
        'lon_finish' => $faker->longitude,
        'lat_finish' => $faker->latitude,
        'distance' => $faker->randomFloat(2, 0),
        'pressure' => $faker->numberBetween(990, 1025),
        'humidity' => $faker->numberBetween(30, 100),
        'wind_speed' => $faker->numberBetween(0, 120),
        'wind_direction' => $faker->text(3),
        'mood' => $faker->numberBetween(1, 5),
        'health' => $faker->numberBetween(1, 5),
        'avg_hr' => $faker->numberBetween(60, 190),
        'max_hr' => $faker->numberBetween(60, 190),
    ];
});

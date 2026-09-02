<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Workout::class, function (Faker $faker) {
    return [
        'name' => $faker->text(200),
        'user_id' => $faker->numberBetween(1, 3),
        'date' => $faker->date(),
        'start_time' => $faker->time(),
        'time_in_seconds' => $faker->randomNumber(4),
        'finished' => $faker->boolean,
        'description' => $faker->paragraph(),
        'lon_start' => $faker->optional()->longitude,
        'lat_start' => $faker->optional()->latitude,
        'lon_finish' => $faker->optional()->longitude,
        'lat_finish' => $faker->optional()->latitude,
        'distance' => $faker->randomFloat(2, 0),
        'pressure' => $faker->optional()->numberBetween(990, 1025),
        'humidity' => $faker->optional()-> numberBetween(30, 100),
        'temperature' => $faker->optional()->numberBetween(30, 100),
        'wind_speed' => $faker->optional()->numberBetween(0, 120),
        'wind_direction' => $faker->optional()->randomElement(['N','E','S','W','NE', 'SE', 'SW','NW']),
        'mood' => $faker->numberBetween(1, 5),
        'health' => $faker->numberBetween(1, 5),
        'avg_hr' => $faker->optional()->numberBetween(60, 170),
        'max_hr' => $faker->optional()->numberBetween(140, 190),
    ];
});

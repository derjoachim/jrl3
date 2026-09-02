<?php

use Faker\Generator as Faker;

$factory->define(App\Models\FitnessService::class, function (Faker $faker) {
    return [
        'name' => $faker->text(200),
        'slug' => $faker->slug,
        'api_key' => $faker->sha256,
        'description' => $faker->realText()
    ];
});

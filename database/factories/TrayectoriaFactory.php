<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Trayectoria::class, function (Faker $faker) {
    return [
        'force_field' => $faker->word,
        'resolution' => $faker->word,
        'membrane_name' => $faker->word,
        'membrane_geometry' => $faker->word,
        'membrane_model' => $faker->word,
        'length' => $faker->randomNumber(),
        'timestep' => $faker->randomNumber(),
        'electric_field' => $faker->randomFloat(),
        'temperature' => $faker->randomFloat(),
        'pressure' => $faker->word,
        'number_of_particles' => $faker->randomNumber(),
        'input_folder' => $faker->word,
        'output_folder' => $faker->word,
        'software_name' => $faker->word,
        'software_version' => $faker->word,
        'supercomputer' => $faker->word,
        'trajectory_url' => $faker->word,
        'performance' => $faker->randomFloat(2, 0, 8),
    ];
});

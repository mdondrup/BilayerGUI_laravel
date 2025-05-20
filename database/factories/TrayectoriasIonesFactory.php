<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Console\Commands\GenerarDatosDePrueba;
use Faker\Generator as Faker;

$factory->define(App\TrayectoriasIones::class, function (Faker $faker) {
    return [
        'trajectory_id' => $faker->numberBetween(GenerarDatosDePrueba::INICIO_ID, GenerarDatosDePrueba::FIN_ID),
        'ion_id' => $faker->numberBetween(GenerarDatosDePrueba::INICIO_ID, GenerarDatosDePrueba::FIN_ID),
        'ion_name' => $faker->word,
        'bulk' => $faker->randomNumber(),
    ];
});

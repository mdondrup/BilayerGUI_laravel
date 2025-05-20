<?php

/* @var $factory Factory */

use App\Console\Commands\GenerarDatosDePrueba;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(App\TrayectoriasPeptidos::class, function (Faker $faker) {
    return [
        'trajectory_id' => $faker->numberBetween(GenerarDatosDePrueba::INICIO_ID, GenerarDatosDePrueba::FIN_ID),
        'peptide_id' => $faker->numberBetween(GenerarDatosDePrueba::INICIO_ID, GenerarDatosDePrueba::FIN_ID),
        'membrane' => $faker->randomNumber(),
        'bulk' => $faker->randomNumber(),
        'up' => $faker->dateTime(),
    ];
});

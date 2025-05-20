<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Console\Commands\GenerarDatosDePrueba;
use Faker\Generator as Faker;

$factory->define(App\TrayectoriasLipidos::class, function (Faker $faker) {
    return [
        'trajectory_id' => $faker->numberBetween(GenerarDatosDePrueba::INICIO_ID, GenerarDatosDePrueba::FIN_ID),
        'lipid_id' => $faker->numberBetween(GenerarDatosDePrueba::INICIO_ID, GenerarDatosDePrueba::FIN_ID),
        'lipid_name' => $faker->word,
        'leaflet_1' => $faker->randomNumber(),
        'leaflet_2' => $faker->randomNumber(),
    ];
});

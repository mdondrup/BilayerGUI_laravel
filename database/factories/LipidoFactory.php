<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Lipido::class, function (Faker $faker) {
    return [
        'short_name' => $faker->word,
        'full_name' => $faker->word,
        'force_field' => $faker->word,
        'resolution' => $faker->word,
        'number_particles' => $faker->randomNumber(),
        'total_charge' => $faker->randomNumber(),
        'itpfile' => $faker->text,
        'reference' => $faker->text,
        'url' => $faker->url,
    ];
});

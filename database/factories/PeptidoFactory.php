<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Peptido::class, function (Faker $faker) {
    return [

        'name' => $faker->name,
        'total_charge' => $faker->randomNumber(),
        'length' => $faker->randomNumber(),
        'electrostatic_dipolar_moment' => $faker->randomFloat(2, 0, 8),
        'edm_longitudinal' => $faker->randomFloat(2, 0, 8),
        'edm_transversal' => $faker->randomFloat(2, 0, 8),
        'hydrophobic_dipolar_moment' => $faker->randomFloat(2, 0, 8),
        'hdm_longitudinal' => $faker->randomFloat(2, 0, 8),
        'hdm_transversal' => $faker->randomFloat(2, 0, 8),
        'type' => $faker->word,
        'sequence' => $faker->word,
        'reference' => $faker->text,
        'url' => $faker->url,
        'dramp_id' => $faker->word,
        'secondary_structure' => $faker->word,
        'activity' => $faker->word,
        'source' => $faker->word,
        'basic_residues' => $faker->randomNumber(),
        'acidic_residues' => $faker->randomNumber(),
        'hydrophobic_residues' => $faker->randomNumber(),
        'polar_residues' => $faker->randomNumber(),
        'swiss_prot_entry' => $faker->word,
        'pdb_id' => $faker->word,
        'folder_pdb' => $faker->word,
    ];
});

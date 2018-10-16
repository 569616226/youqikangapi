<?php


$factory->define(App\Containers\Plan\Models\Plan::class, function (Faker\Generator $faker) {

    return [
        'name'       => $faker->name,
        'editer'     => $faker->name,
        'is_parent'  => false,
        'created_at' => now()
    ];
});


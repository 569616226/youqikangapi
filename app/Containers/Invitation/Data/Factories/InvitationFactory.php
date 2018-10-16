<?php


$factory->define(App\Containers\Invitation\Models\Invitation::class, function (Faker\Generator $faker) {

    return [
        'code'       => $faker->numberBetween(100000, 99999),
        'depart_ids' => null,
        'report_id'  => null
    ];
});


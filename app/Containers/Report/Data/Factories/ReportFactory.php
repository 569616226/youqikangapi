<?php


$factory->define(App\Containers\Report\Models\Report::class, function (Faker\Generator $faker) {

    return [
        'name'     => $faker->name,
        'order_id' => null,
    ];
});


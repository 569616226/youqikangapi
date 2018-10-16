<?php


$factory->define(App\Containers\ReportDepart\Models\ReportDepart::class, function (Faker\Generator $faker) {

    return [
        'name'       => $faker->name,
        'icon'       => $faker->imageUrl(80, 80),
        'report_id'  => null,
        'created_at' => now()
    ];
});


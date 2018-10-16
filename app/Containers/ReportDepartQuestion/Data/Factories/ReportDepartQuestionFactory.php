<?php


$factory->define(App\Containers\ReportDepartQuestion\Models\ReportDepartQuestion::class, function (Faker\Generator $faker) {

    return [
        'question'         => $faker->name,
        'answers'          => ['是', '否'],
        'report_depart_id' => null,
        'created_at'       => now()
    ];
});


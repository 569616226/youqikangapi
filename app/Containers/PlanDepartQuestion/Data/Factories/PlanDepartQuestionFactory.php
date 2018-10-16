<?php


$factory->define(App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion::class, function (Faker\Generator $faker) {

    return [
        'question'       => $faker->name,
        'answers'        => ['是', '否'],
        'plan_depart_id' => null,
        'created_at'     => now()
    ];
});


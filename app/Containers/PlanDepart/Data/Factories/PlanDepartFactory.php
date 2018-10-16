<?php


$factory->define(App\Containers\PlanDepart\Models\PlanDepart::class, function (Faker\Generator $faker) {

    return [
        'name'       => $faker->name,
        'icon'       => $faker->imageUrl(80, 80),
        'plan_id'    => null,
        'created_at' => now()
    ];
});


<?php


$factory->define(App\Containers\Company\Models\Company::class, function (Faker\Generator $faker) {

    return [
        'name'       => $faker->name,
        'logo'       => $faker->imageUrl(80, 80),
        'creator'    => '系统',
        'created_at' => now()
    ];
});


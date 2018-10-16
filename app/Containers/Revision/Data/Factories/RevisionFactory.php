<?php


$factory->define(App\Containers\Revision\Models\Revision::class, function (Faker\Generator $faker) {

    return [
        'revisionable_type' => 'App\\Containers\\User\\Models\\User',
        'revisionable_id'   => 1,
        'key'               => 'deleted_at',
        'created_at'        => now()
    ];
});


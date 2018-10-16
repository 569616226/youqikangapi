<?php

use Illuminate\Support\Facades\Hash;

$factory->define(App\Containers\User\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'            => $faker->name,
        'username'        => $faker->name,
        'password'        => $password ?: $password = Hash::make('testing-password'),
        'remember_token'  => str_random(10),
        'is_client'       => false,
        'is_audit'        => false,
        'is_frozen'       => false,
        'is_client_admin' => false,
        'created_at'      => now()
    ];
});

$factory->state(App\Containers\User\Models\User::class, 'client', function (Faker\Generator $faker) {
    return [
        'is_client' => true,
    ];
});

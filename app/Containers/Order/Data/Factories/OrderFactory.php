<?php


$factory->define(App\Containers\Order\Models\Order::class, function (Faker\Generator $faker) {

    return [
        'name'         => $faker->name,
        'status'       => '未开始',
        'order_number' => create_order_number(),
        'plan_id'      => null,
        'company_id'   => null,
        'created_at'   => now()
    ];
});


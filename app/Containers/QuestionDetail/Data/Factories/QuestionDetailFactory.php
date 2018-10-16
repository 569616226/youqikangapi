<?php


$factory->define(App\Containers\QuestionDetail\Models\QuestionDetail::class, function (Faker\Generator $faker) {

    return [
        'question'                => $faker->name,
        'answer'                  => $faker->text,
        'plan_depart_question_id' => null,
        'created_at'              => now()
    ];
});


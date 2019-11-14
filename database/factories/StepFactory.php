<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Step;
use Faker\Generator as Faker;

$factory->define(Step::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence,
        'task_id' => factory(\App\Task::class),
    ];
});

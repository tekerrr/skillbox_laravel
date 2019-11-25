<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'body' => $faker->sentence,
        'owner_id' => factory(\App\User::class),
        'type' => $faker->randomElement(['new', 'old', 'fast']),
    ];
});

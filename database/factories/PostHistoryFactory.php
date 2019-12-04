<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PostHistory;
use Faker\Generator as Faker;

$factory->define(PostHistory::class, function (Faker $faker) {
    return [
        'post_id' => factory(\App\Post::class),
        'user_id' => factory(\App\User::class),
        'before'  => json_encode([($field = $faker->word) => $faker->sentence]),
        'after'   => json_encode([$field => $faker->sentence]),
    ];
});

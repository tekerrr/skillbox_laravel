<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'owner_id'  => factory(\App\User::class)->create(),
        'title'     => $title = $faker->words(3, true),
        'slug'      => \Illuminate\Support\Str::slug($title, '_'),
        'abstract'  => $faker->sentence,
        'body'      => $faker->text,
        'is_active' => true,
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {
    return [
        'title'     => $title = $faker->words(3, true),
        'slug'      => \Illuminate\Support\Str::slug($title, '_'),
        'abstract'  => $faker->sentence,
        'body'      => $faker->text,
        'is_active' => true,
    ];
});

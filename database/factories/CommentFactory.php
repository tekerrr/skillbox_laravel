<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $commentables = [
        \App\Post::class,
        \App\News::class,
    ];
    $commentableType = $faker->randomElement($commentables);
    $commentable = factory($commentableType);

    return [
        'owner_id' => factory(\App\User::class),
        'body'     => $faker->sentence,
        'commentable_type' => $commentableType,
        'commentable_id' => $commentable,
    ];
});
$factory->state(Comment::class, 'empty', function () {
    return [
        'owner_id' => '',
        'commentable_type' => '',
        'commentable_id' => '',
    ];
});
$factory->state(Comment::class, 'withoutCommentable', function () {
    return [
        'commentable_type' => '',
        'commentable_id' => '',
    ];
});

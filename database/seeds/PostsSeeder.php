<?php

use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
        {
        /** @var \Illuminate\Support\Collection $posts */
        $posts = factory(\App\Post::class, 10)->create();

        $posts->each(function (\App\Post $post) {
            $post->tags()->saveMany(factory(\App\Tag::class, rand(1, 5))->make());
        });
    }
}

<?php

use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(\App\User::class, 5)->create();
        $tags = factory(\App\Tag::class, 30)->create();

        $users->each(function (\App\User $user) use ($tags) {
            $posts = factory(\App\Post::class, 5)->create(['owner_id' => $user]);

            $posts->each(function (\App\Post $post) use ($tags) {
                $post->tags()->attach($tags->random(rand(1, 5)));

                $comments = factory(\App\Comment::class, rand(1, 5))
                    ->state('empty')
                    ->make()
                    ->each(function ($comment) {
                        $comment->owner_id = \App\User::inRandomOrder()->first()->id;
                    })
                ;

                $post->comments()->saveMany($comments);
            });
        });

        factory(\App\News::class, 10)->create()->each(function (\App\News $news) use ($tags) {
            $news->tags()->attach($tags->random(rand(1, 5)));
        });
    }
}

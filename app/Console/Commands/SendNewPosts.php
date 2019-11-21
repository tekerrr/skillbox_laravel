<?php

namespace App\Console\Commands;

use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendNewPosts extends Command
{
    protected $signature = 'send:new-posts {period : days}';

    protected $description = 'Notification for all users about new posts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (($period = $this->argument('period')) <= 0) {
            $this->alert('Enter a positive number of days');
            return;
        }

        /** @var \Illuminate\Support\Collection $posts */
        $posts = Post::where('created_at', '>', Carbon::now()->subDays($period))->get();

        if ($posts->count() <= 0) {
            $this->info('No new articles');
            return;
        }

        \Notification::send(User::all(), new \App\Notifications\NewPosts($posts, $period));

        $this->info('Notified about ' . $posts->count() .' posts');
    }
}

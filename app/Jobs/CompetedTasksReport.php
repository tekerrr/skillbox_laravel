<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompetedTasksReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public $tries = 5;
//
//    public function retryUntil()
//    {
//        return now()->addSecond(10);
//    }
//
//    public $timeout = 30;

    protected $owner;

    public $deleteWhenMissingModels = true;

    public function __construct(User $user = null)
    {
        $this->owner = $user;
    }

    public function handle()
    {
        throw new \Exception('Some Error');

        $tasksCount = \App\Task::when(null !== $this->owner, function ($query) {
                $query->where('owner_id', $this->owner->id);
            })
            ->completed()
            ->count()
        ;
        $stepsCount = \App\Step::when(null !== $this->owner, function ($query) {
                $query->whereHas('owner', function ($query) {
                    $query->where('users.id', '=', $this->owner->id);
                });
            })
            ->completed()
            ->count()
        ;

        echo ($this->owner ? $this->owner->name : 'Всего') . ": выполненных шагов: $stepsCount, Выполненных задач: $tasksCount";
    }

    public function failed(\Exception $exception)
    {
        \Log::error($exception->getMessage());
    }
}

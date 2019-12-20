<?php

namespace App\Broadcasting;

use App\Task;
use App\User;

class TaskChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param Task $task
     * @return array|bool
     */
    public function join(User $user, Task $task)
    {
        return $user->id === $task->owner_id;
    }
}

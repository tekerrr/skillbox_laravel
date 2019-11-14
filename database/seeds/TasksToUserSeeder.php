<?php

use Illuminate\Database\Seeder;

class TasksToUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'Alex Anufriev',
            'email' => 'tekerrr@gmail.com',
            'password' => Hash::make('klop'),

        ]);

        factory(\App\Task::class, 5)->create([
            'owner_id' => $user
        ])->each(function (\App\Task $task) {
            $task->steps()->saveMany(factory(\App\Step::class, rand(1, 5))->make(['task_id' => '']));
        });
    }
}

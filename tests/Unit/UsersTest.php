<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanHaveTasks()
    {
        $user = factory(User::class)->create();

        $attributes = factory(\App\Task::class)->raw(['owner_id' => $user]);

        $user->tasks()->create($attributes);

        $this->assertEquals($attributes['title'], $user->tasks->first()->title);
    }

    public function testAUserCanHaveACompany()
    {
        $user = factory(User::class)->create();

        $user->company()->create(['name' => 'Skillbox']);

        $this->assertEquals('Skillbox', $user->company->name);
    }
}

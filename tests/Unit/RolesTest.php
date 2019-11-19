<?php

namespace Tests\Unit;

use App\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    public function testARoleCanHasAUser()
    {
        $role = factory(Role::class)->create();
        $user = factory(\App\User::class)->create();

        $role->users()->attach($user);

        $this->assertEquals($user->name, $role->users->first()->name);
    }
}

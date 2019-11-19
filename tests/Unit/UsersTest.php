<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testAUserCanHasARole()
    {
        $user = factory(User::class)->create();
        $role = factory(\App\Role::class)->create();

        $user->roles()->attach($role);

        $this->assertEquals($role->role, $user->roles->first()->role);
    }

    public function testAUserCanHasARoleByMethod()
    {
        $user = factory(User::class)->create();
        $role = factory(\App\Role::class)->create();

        $user->roles()->attach($role);

        $this->assertTrue($user->hasRole($role->role));
        $this->assertFalse($user->hasRole($this->faker->words(2, true)));
    }

    public function testARoleCanBeAddedToUser()
    {
        $user = factory(User::class)->create();

        $user->addRole($role = $this->faker->word);

        $this->assertEquals($role, $user->roles->first()->role);
    }

    public function testAdminDefinedAsAdmin()
    {
        $user = factory(User::class)->create();
        $user->addRole('admin');

        $response = $user->isAdmin();

        $this->assertTrue($response);
    }

    public function testAUserIsNotDefinedAsAdmin()
    {
        $user = factory(User::class)->create();

        $response = $user->isAdmin();

        $this->assertFalse($response);
    }

    public function testSuperAdminDefinedAsSuperAdmin()
    {
        $user = factory(User::class)->create();
        $user->addRole('super_admin');

        $response = $user->isSuperAdmin();

        $this->assertTrue($response);
    }

    public function testAdminIsNotDefinedAsSuperAdmin()
    {
        $user = factory(User::class)->create();
        $user->addRole('admin');

        $response = $user->isSuperAdmin();

        $this->assertFalse($response);
    }

    public function testAUserIsNotDefinedAsSuperAdmin()
    {
        $user = factory(User::class)->create();

        $response = $user->isSuperAdmin();

        $this->assertFalse($response);
    }
}

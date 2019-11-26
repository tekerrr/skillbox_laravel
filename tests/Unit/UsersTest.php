<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\WithRoles;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    /** @test */
    public function a_user_can_have_roles()
    {
        // Arrange
        $user = $this->createUser();
        $roles = factory(\App\Role::class, 2)->create();

        // Act
        $user->roles()->attach($roles);

        // Assert
        $this->assertTrue($user->hasRole($roles->first()->role));
        $this->assertTrue($user->hasRole($roles->last()->role));
        $this->assertFalse($user->hasRole($this->faker->words(2, true)));
    }

    /** @test */
    public function a_role_can_be_added_to_a_user()
    {
        // Arrange
        $user = $this->createUser();

        // Act
        $user->addRole($role = $this->faker->word);

        // Assert
        $this->assertEquals($role, $user->roles->first()->role);
    }

    /** @test */
    public function an_admin_is_defined_as_admin()
    {
        // Arrange
        $user = $this->createAdmin();

        // Act
        $response = $user->isAdmin();

        // Assert
        $this->assertTrue($response);
    }

    /** @test */
    public function a_user_is_not_defined_as_admin()
    {
        // Arrange
        $user = $this->createUser();

        // Act
        $response = $user->isAdmin();

        // Assert
        $this->assertFalse($response);
    }

    /** @test */
    public function a_super_admin_is_defined_as_super_admin()
    {
        // Arrange
        $user = $this->createSuperAdmin();

        // Act
        $response = $user->isSuperAdmin();

        // Assert
        $this->assertTrue($response);
    }

    /** @test */
    public function an_admin_is_not_defined_as_super_admin()
    {
        // Arrange
        $user = $this->createAdmin();

        // Act
        $response = $user->isSuperAdmin();

        // Assert
        $this->assertFalse($response);
    }

    /** @test */
    public function a_user_is_not_defined_as_super_admin()
    {
        // Arrange
        $user = $this->createUser();

        // Act
        $response = $user->isSuperAdmin();

        // Assert
        $this->assertFalse($response);
    }
}

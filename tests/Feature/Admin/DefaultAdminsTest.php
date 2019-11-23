<?php

namespace Tests\Feature\Admin;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefaultAdminsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_default_admin()
    {
        // Arrange
        $user = User::where('name', 'Admin')->first();

        // Act
        $response = $user->isAdmin();

        // Assert
        $this->assertTrue($response);
    }

    /** @test */
    public function check_default_super_admin() // TODO изменить
    {
        // Arrange
        $user = User::where('name', 'Super Admin')->first();

        // Act
        $response = $user->isSuperAdmin();

        // Assert
        $this->assertTrue($response);
    }
}

<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function testCheckSuperAdmin()
    {
        $superAdmin = User::where('name', 'Super Admin')->first();

        $this->assertTrue($superAdmin->isSuperAdmin());
    }

    public function testCheckAdmin()
    {
        $superAdmin = User::where('name', 'Admin')->first();

        $this->assertTrue($superAdmin->isAdmin());
    }
}

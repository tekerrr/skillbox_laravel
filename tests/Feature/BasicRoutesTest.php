<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BasicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function testDefaultRedirect()
    {
        $response = $this->get('/');

        $response->assertRedirect('/posts');
    }

    public function testAnyoneViewGetAboutPage()
    {
        $response = $this->get('/about');

        $response->assertViewIs('about');
    }

    public function testAnyoneCanViewContactsPage()
    {
        $response = $this->get('/contacts');

        $response->assertViewIs('contacts');
    }

    public function testAdminCanViewAdminPage()
    {
        $this->actingAs(factory(\App\User::class)->create()->addRole('admin'));

        $response = $this->get('/admin');

        $response->assertViewIs('admin.index');
    }

    public function testUserCannotViewAdminPage()
    {
        $this->actingAs(factory(\App\User::class)->create());

        $response = $this->get('/admin');

        $response->assertStatus(403);
    }

    public function testGuestCannotViewAdminPage()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }


}

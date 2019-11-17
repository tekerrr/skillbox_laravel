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

    public function testAboutRoute()
    {
        $response = $this->get('/about');

        $response->assertViewIs('about');
    }

    public function testContactsRoute()
    {
        $response = $this->get('/contacts');

        $response->assertViewIs('contacts');
    }

    public function testAdminRoute()
    {
        $response = $this->get('/admin');

        $response->assertViewIs('admin.index');
    }
}

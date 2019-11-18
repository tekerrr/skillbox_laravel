<?php

namespace Tests\Feature;

use App\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeedbacksTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanViewIndexPage()
    {
        $this->actingAs(factory(\App\User::class)->create()->addRole('admin'));

        $response = $this->get('/admin/feedback');

        $response->assertViewIs('admin.feedback');
    }

    public function testUserCannotViewIndexPage()
    {
        $this->actingAs(factory(\App\User::class)->create());

        $response = $this->get('/admin/feedback');

        $response->assertStatus(403);
    }

    public function testGuestCanViewIndexPage()
    {
        $response = $this->get('/admin/feedback');

        $response->assertStatus(403);
    }

    public function testAnyoneCanCreateAPost()
    {
        $attributes = factory(Feedback::class)->raw();

        $this->post('/admin/feedback', $attributes);

        $this->assertDatabaseHas((new Feedback())->getTable(), $attributes);
    }
}

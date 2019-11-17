<?php

namespace Tests\Feature;

use App\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeedbacksTest extends TestCase
{
    use RefreshDatabase;

    public function testAnyoneCanViewIndexPage()
    {
        $response = $this->get('/admin/feedback');

        $response->assertViewIs('admin.feedback');
    }

    public function testAnyoneCanCreateAPost()
    {
        $attributes = factory(Feedback::class)->raw();

        $this->post('/admin/feedback', $attributes);

        $this->assertDatabaseHas((new Feedback())->getTable(), $attributes);
    }
}

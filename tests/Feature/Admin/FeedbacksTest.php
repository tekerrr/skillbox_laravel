<?php

namespace Tests\Feature\Admin;

use App\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\WithRoles;

class FeedbacksTest extends TestCase
{
    use RefreshDatabase, WithRoles;

    /** @test */
    public function an_admin_can_view_the_feedback_list_page()
    {
        // Arrange
        $this->actingAsAdmin();

        // Act
        $response = $this->get('/admin/feedback');

        // Assert
        $response->assertViewIs('admin.feedback');
        $response->assertSeeText('Список обращений');
    }
}

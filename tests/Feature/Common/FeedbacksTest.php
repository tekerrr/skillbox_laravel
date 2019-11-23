<?php

namespace Tests\Feature\Common;

use App\Feedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbacksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_create_a_feedback()
    {
        // Arrange
        $attributes = factory(Feedback::class)->raw();

        // Act
        $this->post('/feedback', $attributes);

        // Assert
        $this->assertDatabaseHas((new Feedback())->getTable(), $attributes);
    }
}

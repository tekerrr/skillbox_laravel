<?php

namespace Tests\Unit;

use App\Feedback;
use App\Service\TaggedCache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function creating_feedback_flushes_feedbacks_cache()
    {
        // Arrange
        TaggedCache::feedbacks()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        factory(Feedback::class)->create();

        // Assert
        $this->assertNull(TaggedCache::feedbacks()->getCache()->get('cache'));
    }

    /** @test */
    public function updating_feedback_flushes_feedbacks_cache()
    {
        // Arrange
        $feedback = factory(Feedback::class)->create();
        TaggedCache::feedbacks()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $feedback->update(['body' => $this->faker->words(3, true)]);

        // Assert
        $this->assertNull(TaggedCache::feedbacks()->getCache()->get('cache'));
    }

    /** @test */
    public function deleting_feedback_flushes_feedback_cache()
    {
        // Arrange
        $feedback = factory(Feedback::class)->create();
        TaggedCache::feedbacks()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $feedback->delete();

        // Assert
        $this->assertNull(TaggedCache::feedbacks()->getCache()->get('cache'));
    }
}

<?php

namespace Tests\Unit;

use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class CommentTest extends TestCase
{
    use RefreshDatabase, WithRoles;

        /** @test */
    public function a_comment_has_a_user()
    {
        // Arrange
        $comment = factory(Comment::class)->create(['owner_id' => $user = $this->createUser()]);

        // Act
        $owner = $comment->user;

        // Assert
        $this->assertEquals($owner->name, $user->name);
    }
}

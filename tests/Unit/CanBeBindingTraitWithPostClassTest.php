<?php

namespace Tests\Unit;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanBeBindingTraitWithPostClassTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function method_get_binding_returns_bounded_post()
    {
        // Arrange
        factory(Post::class)->create();
        $post = factory(Post::class)->create();
        factory(Post::class)->create();

        // Act
        $response = Post::getBindingModel($post->slug);

        // Assert
        $this->assertEquals($post->title, $response->title);
    }

    /** @test */
    public function method_get_binding_throws_exception_when_key_not_exists()
    {
        // Arrange
        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);

        // Act
        $response = Post::getBindingModel($this->faker->word);
    }
}

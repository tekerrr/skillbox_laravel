<?php

namespace Tests\Feature\RequestValidation;

use App\Post;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\WithRoles;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    public function invalidDataProvider()
    {
        $faker = Factory::create();

        return [
            'empty_slug' => ['slug', ''],
            'cyrillic_slug' => ['slug', 'Кириллица'],
            'slug_with_spaces' => ['slug', $faker->words(3, true)],
            'empty_title' => ['title', ''],
            'short_title' => ['title', $faker->regexify('[A-Za-z]{4}')],
            'long_title' => ['title', $faker->regexify('[A-Za-z]{110}')],
            'empty_abstract' => ['abstract', ''],
            'long_abstract' => ['abstract', $faker->regexify('[A-Za-z]{260}')],
            'empty_body' => ['body', ''],
        ];
    }

    /** @test */
    public function the_valid_data_passes_the_validation_rules()
    {
        // Arrange
        $attributes = factory(Post::class)->raw(['owner_id' => $this->actingAsUser()]);
        $post = Post::create($attributes);

        // Act
        $attributes['title'] = $this->faker->words(3, true);
        $response = $this->patch('/posts/' . $post->slug, $attributes);

        // Assert
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     * @dataProvider invalidDataProvider
     * @param string $field
     * @param string $value
     */
    public function the_invalid_data_fails_the_validation_rules(string $field, string $value)
    {
        // Arrange
        $attributes = factory(Post::class)->raw(['owner_id' => $this->actingAsUser()]);
        $post = Post::create($attributes);

        // Act
        $attributes[$field] = $value;
        $response = $this->patch('/posts/' . $post->slug, $attributes);

        // Assert
        $response->assertSessionHasErrors([$field]);
    }

    /** @test */
    public function the_non_unique_slug_fails_validation_rules()
    {
        // Arrange
        $slug = $this->faker->word;
        factory(Post::class)->create(['slug' => $slug]);
        $attributes = factory(Post::class)->raw(['owner_id' => $this->actingAsUser()]);
        $post = Post::create($attributes);

        // Act
        $attributes['slug'] = $slug;
        $response = $this->patch('/posts/' . $post->slug, $attributes);

        // Assert
        $response->assertSessionHasErrors(['slug']);
    }
}

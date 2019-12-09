<?php

namespace Tests\Unit;

use App\Http\Requests\SaveAbstractArticle;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Tests\WithRoles;

class SaveAbstractArticleTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    /** @test */
    public function the_valid_data_passes_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw();
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function the_empty_slug_fails_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw(['slug' => '']);
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function the_cyrillic_slug_fails_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw(['slug' => 'Кириллица']);
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function the_slug_with_spaces_fails_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw(['slug' => $this->faker->words(3, true)]);
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function the_empty_title_fails_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw(['title' => '']);
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function the_short_title_fails_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw(['title' => 'abc']);
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function the_long_title_fails_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw(['title' => $this->faker->text(200)]);
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function the_empty_abstract_fails_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw(['abstract' => '']);
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function the_long_abstract_fails_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw(['abstract' => $this->faker->text(500)]);
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function the_empty_body_fails_the_validation_rules()
    {
        // Arrange
        $this->actingAsUser();
        $request = factory(Post::class)->raw(['body' => '']);
        $rules = (new SaveAbstractArticle())->rules();

        // Act
        $validator = Validator::make($request, $rules);

        // Assert
        $this->assertTrue($validator->fails());
    }
}

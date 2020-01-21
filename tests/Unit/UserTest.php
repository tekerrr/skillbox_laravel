<?php

namespace Tests\Unit;

use App\Service\TaggedCache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\WithRoles;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithRoles;

    /** @test */
    public function a_user_can_have_roles()
    {
        // Arrange
        $user = $this->createUser();
        $roles = factory(\App\Role::class, 2)->create();

        // Act
        $user->roles()->attach($roles);

        // Assert
        $this->assertTrue($user->hasRole($roles->first()->role));
        $this->assertTrue($user->hasRole($roles->last()->role));
        $this->assertFalse($user->hasRole($this->faker->words(2, true)));
    }

    /** @test */
    public function a_user_can_have_posts()
    {
        // Arrange
        $user = $this->createUser();
        $posts = factory(\App\Post::class, 2)->make(['owner_id' => '']);

        // Act
        $user->posts()->saveMany($posts);

        // Assert
        $this->assertEquals($user->posts->first()->body, $posts->first()->body);
        $this->assertEquals($user->posts->last()->body, $posts->last()->body);
    }

    /** @test */
    public function a_user_can_have_comments()
    {
        // Arrange
        $user = $this->createUser();
        $comments = factory(\App\Comment::class, 2)->make(['owner_id' => '']);

        // Act
        $user->comments()->saveMany($comments);

        // Assert
        $this->assertEquals($user->comments->first()->body, $comments->first()->body);
        $this->assertEquals($user->comments->last()->body, $comments->last()->body);
    }

    /** @test */
    public function a_role_can_be_added_to_a_user()
    {
        // Arrange
        $user = $this->createUser();

        // Act
        $user->addRole($role = $this->faker->word);

        // Assert
        $this->assertEquals($role, $user->roles->first()->role);
    }

    /** @test */
    public function an_admin_is_defined_as_admin()
    {
        // Arrange
        $user = $this->createAdmin();

        // Act
        $response = $user->isAdmin();

        // Assert
        $this->assertTrue($response);
    }

    /** @test */
    public function a_user_is_not_defined_as_admin()
    {
        // Arrange
        $user = $this->createUser();

        // Act
        $response = $user->isAdmin();

        // Assert
        $this->assertFalse($response);
    }

    /** @test */
    public function a_super_admin_is_defined_as_super_admin()
    {
        // Arrange
        $user = $this->createSuperAdmin();

        // Act
        $response = $user->isSuperAdmin();

        // Assert
        $this->assertTrue($response);
    }

    /** @test */
    public function an_admin_is_not_defined_as_super_admin()
    {
        // Arrange
        $user = $this->createAdmin();

        // Act
        $response = $user->isSuperAdmin();

        // Assert
        $this->assertFalse($response);
    }

    /** @test */
    public function a_user_is_not_defined_as_super_admin()
    {
        // Arrange
        $user = $this->createUser();

        // Act
        $response = $user->isSuperAdmin();

        // Assert
        $this->assertFalse($response);
    }

    /** @test */
    public function updating_username_flushes_users_cache()
    {
        // Arrange
        $user = $this->createUser();
        TaggedCache::users()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $user->update(['name' => $this->faker->name]);

        // Assert
        $this->assertNull(TaggedCache::users()->getCache()->get('cache'));
    }

    /** @test */
    public function updating_user_attributes_without_name_flushes_users_cache()
    {
        // Arrange
        $user = $this->createUser();
        $cache = TaggedCache::users()->remember('cache', function () {
            return $this->faker->words(3, true);
        });

        // Act
        $user->update(['email' => $this->faker->email]);

        // Assert
        $this->assertEquals($cache, TaggedCache::users()->getCache()->get('cache'));
    }
}

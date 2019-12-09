<?php

namespace Tests\Unit;

use App\CanBeActivated;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanBeActivatedTraitTest extends TestCase
{
    /** @test */
    public function a_abstract_class_can_be_activated()
    {
        // Arrange
        $mock = $this->getMockForTrait(
            CanBeActivated::Class,
            [],
            '',
            true,
            true,
            true,
            ['update']
        );
        $mock->expects($this->atLeastOnce())
            ->method('update')
            ->with($this->equalTo(['is_active' => true]))
        ;

        // Act
        $mock = $mock->activate();

        // Assert
        $this->assertIsObject($mock);
    }

    /** @test */
    public function a_abstract_class_can_be_deactivated()
    {
        // Arrange
        $mock = $this->getMockForTrait(
            CanBeActivated::Class,
            [],
            '',
            true,
            true,
            true,
            ['update']
        );
        $mock->expects($this->atLeastOnce())
            ->method('update')
            ->with($this->equalTo(['is_active' => false]))
        ;

        // Act
        $mock = $mock->deactivate();

        // Assert
        $this->assertIsObject($mock);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanCreateACompany()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory(\App\User::class)->create());

        $this->post('/companies', $attributes = ['name' => 'Qsoft']);

        $this->assertDatabaseHas('companies', $attributes);
    }

    public function testItRequiresNameOnCreate()
    {
        $this->actingAs(factory(\App\User::class)->create());

        $this->post('/companies', $attributes = [])->assertSessionHasErrors(['name']);
    }

    public function testGuestMayNotCreateACompany()
    {
        $this->post('/companies', [])->assertRedirect('/login');
    }
}

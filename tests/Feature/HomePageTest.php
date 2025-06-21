<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /** @test */
    public function the_home_page_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function the_home_page_uses_inertia_with_welcome_component()
    {
        $response = $this->get('/');

        $response->assertInertia(fn ($assert) => $assert->component('Welcome.new'));
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    /** @test */
    public function urlValida()
    {
        $response = $this->get(route('welcome'));
        $response->assertStatus(200);
    }
}

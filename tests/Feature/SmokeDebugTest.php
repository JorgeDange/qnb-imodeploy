<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeDebugTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_renderiza_via_http(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<html', false);
    }
}

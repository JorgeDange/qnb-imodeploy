<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeDebugTest extends TestCase
{
    use RefreshDatabase;

    public function test_sem_cache(): void
    {
        $this->seed();
        $admin = Admin::where('email', 'admin@qnbangola.com')->firstOrFail();
        $this->actingAs($admin, 'admin');
        config(['cache.default' => 'array']);
        $this->get(route('admin.logs'))->assertStatus(200);
    }
}

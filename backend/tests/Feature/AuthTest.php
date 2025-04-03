<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_protected_routes()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)
            ->postJson('/api/content-sync', [
                'data' => [
                    'id' => 1,
                    'name' => 'Test Benefit',
                    'description' => 'Test Description',
                    'eligibility_criteria' => ['age' => 18]
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_regular_user_cannot_access_admin_routes()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/content-sync', [
                'data' => [
                    'id' => 1,
                    'name' => 'Test Benefit'
                ]
            ]);

        $response->assertStatus(403);
    }
} 
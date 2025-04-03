<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Benefits;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BenefitsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_benefits_api_performance_with_redis_caching()
    {
        // Create test user
        $user = User::factory()->create(['role' => 'user']);
        $token = auth()->login($user);

        // Create test benefits
        Benefits::factory()->count(50)->create();

        // First request (uncached)
        $startTime = microtime(true);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/benefits');
        $uncachedTime = microtime(true) - $startTime;

        // Second request (cached)
        $startTime = microtime(true);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/benefits');
        $cachedTime = microtime(true) - $startTime;

        // Assert significant performance improvement with caching
        $this->assertTrue($cachedTime < $uncachedTime * 0.5);
        $this->assertTrue($cachedTime < 0.8); // Less than 800ms
    }
} 
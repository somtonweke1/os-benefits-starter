<?php

namespace Tests\Benchmarks;

use Tests\TestCase;
use App\Models\Benefits;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiBenchmark extends TestCase
{
    use RefreshDatabase;

    public function benchmarkBenefitsApi()
    {
        // Clear cache
        Cache::forget('benefits');
        
        // Create 1000 benefits for realistic testing
        Benefits::factory()->count(1000)->create();

        $results = [];

        // Test without Redis
        Cache::setDefaultDriver('array');
        $start = microtime(true);
        $response = $this->getJson('/api/benefits');
        $results['without_redis'] = round((microtime(true) - $start) * 1000); // Convert to milliseconds

        // Test with Redis
        Cache::setDefaultDriver('redis');
        $start = microtime(true);
        $response = $this->getJson('/api/benefits');
        $results['with_redis'] = round((microtime(true) - $start) * 1000);

        return $results;
    }
} 
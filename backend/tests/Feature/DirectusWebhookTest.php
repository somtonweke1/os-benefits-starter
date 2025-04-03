<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\BenefitsContent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DirectusWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_sync_updates_database_and_clears_cache()
    {
        Cache::put('benefits', 'old-data', 3600);

        $webhookData = [
            'data' => [
                'id' => 'abc123',
                'name' => 'Updated Benefit',
                'description' => 'New Description',
                'eligibility_criteria' => ['income' => 50000]
            ]
        ];

        $response = $this->postJson('/api/content-sync', $webhookData);

        $response->assertStatus(200);

        // Check database was updated
        $this->assertDatabaseHas('benefits_content', [
            'directus_id' => 'abc123',
            'name' => 'Updated Benefit'
        ]);

        // Verify cache was cleared
        $this->assertNull(Cache::get('benefits'));
    }
} 
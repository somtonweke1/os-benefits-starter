<?php

namespace App\Services;

use App\Models\BenefitsContent;
use Illuminate\Support\Facades\Cache;

class DirectusWebhookService
{
    public function handleContentUpdate(array $data)
    {
        // Update local content
        BenefitsContent::updateOrCreate(
            ['directus_id' => $data['id']],
            [
                'name' => $data['name'],
                'description' => $data['description'],
                'eligibility_criteria' => $data['eligibility_criteria'],
                'content' => $data
            ]
        );

        // Clear cache
        Cache::forget('benefits');

        return true;
    }
} 
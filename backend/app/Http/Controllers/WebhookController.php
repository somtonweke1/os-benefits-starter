<?php

namespace App\Http\Controllers;

use App\Services\DirectusWebhookService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    protected $webhookService;

    public function __construct(DirectusWebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    public function handleContentSync(Request $request)
    {
        $data = $request->input('data');
        
        $this->webhookService->handleContentUpdate($data);
        
        return response()->json(['status' => 'success']);
    }
} 
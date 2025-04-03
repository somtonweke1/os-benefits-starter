<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Models\Benefits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

// Auth routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    // Benefits endpoints
    Route::get('/benefits', function (Request $request) {
        return Cache::remember('benefits', 3600, function () {
            return Benefits::with('eligibilityRules')->get();
        });
    });

    // Content sync endpoint
    Route::post('/content-sync', function (Request $request) {
        $content = $request->input('data');
        BenefitsContent::updateOrCreate(
            ['directus_id' => $content['id']],
            $content
        );
        return response()->json(['status' => 'synced']);
    })->middleware('role:admin');
});

// Health check endpoint
Route::get('/health', function () {
    try {
        // Test database connection
        DB::connection()->getPdo();
        // Test Redis connection
        Redis::ping();
        
        return response()->json([
            'status' => 'healthy',
            'services' => [
                'database' => 'connected',
                'redis' => 'connected'
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'unhealthy',
            'error' => $e->getMessage()
        ], 500);
    }
}); 
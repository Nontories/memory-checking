<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/memory-usage', function () {
    $memoryUsage = memory_get_usage(true);
    $peakMemoryUsage = memory_get_peak_usage(true);
    $memoryLimit = ini_get('memory_limit');

    return response()->json([
        'memory_usage' => $memoryUsage, // Bytes
        'memory_usage_mb' => round($memoryUsage / 1024 / 1024, 2) . ' MB',
        'peak_memory_usage' => $peakMemoryUsage, // Bytes
        'peak_memory_usage_mb' => round($peakMemoryUsage / 1024 / 1024, 2) . ' MB',
        'memory_limit' => $memoryLimit,
    ]);
});

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PerformanceMonitoring
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);
        
        $response = $next($request);
        
        $duration = (microtime(true) - $start) * 1000; // Convert to milliseconds
        
        if ($duration > 200) { // Log slow requests
            Log::warning("Slow request detected: {$request->path()} took {$duration}ms");
        }
        
        $response->headers->set('X-Response-Time', "{$duration}ms");
        
        return $response;
    }
} 
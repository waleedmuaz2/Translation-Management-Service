<?php

namespace Tests\Performance;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

abstract class PerformanceTestCase extends TestCase
{
    protected function assertResponseTime($callback, $maxTime = 200)
    {
        $start = microtime(true);
        $callback();
        $end = microtime(true);
        
        $executionTime = ($end - $start) * 1000; // Convert to milliseconds
        
        $this->assertLessThan(
            $maxTime,
            $executionTime,
            "Response time {$executionTime}ms exceeded maximum allowed time of {$maxTime}ms"
        );
    }

    protected function assertQueryCount($callback, $maxQueries = 10)
    {
        DB::enableQueryLog();
        $callback();
        $queryCount = count(DB::getQueryLog());
        DB::disableQueryLog();
        
        $this->assertLessThan(
            $maxQueries,
            $queryCount,
            "Query count {$queryCount} exceeded maximum allowed queries of {$maxQueries}"
        );
    }

    protected function assertMemoryUsage($callback, $maxMemoryMB = 50)
    {
        $startMemory = memory_get_usage(true);
        $callback();
        $endMemory = memory_get_usage(true);
        
        $memoryUsed = ($endMemory - $startMemory) / 1024 / 1024; // Convert to MB
        
        $this->assertLessThan(
            $maxMemoryMB,
            $memoryUsed,
            "Memory usage {$memoryUsed}MB exceeded maximum allowed memory of {$maxMemoryMB}MB"
        );
    }
} 
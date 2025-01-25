<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestPerformanceCommand extends Command
{
    protected $signature = 'test:performance';
    protected $description = 'Run performance tests on API endpoints';

    public function handle()
    {
        $this->info('Running performance tests...');
        
        // Test export endpoint with large dataset
        $start = microtime(true);
        $response = Http::withToken('test-token')
            ->get(config('app.url') . '/api/translations/export');
        $duration = (microtime(true) - $start) * 1000;
        
        $this->info("Export endpoint response time: {$duration}ms");
        
        if ($duration > 500) {
            $this->error('Export endpoint exceeded 500ms threshold!');
        }
        
        // Add more endpoint tests as needed
    }
} 
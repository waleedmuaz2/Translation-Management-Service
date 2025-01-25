<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSwaggerCommand extends Command
{
    protected $signature = 'swagger:generate';
    protected $description = 'Generate Swagger API documentation';

    public function handle()
    {
        $this->info('Generating Swagger documentation...');
        \Artisan::call('l5-swagger:generate');
        $this->info('Documentation generated successfully!');
    }
}
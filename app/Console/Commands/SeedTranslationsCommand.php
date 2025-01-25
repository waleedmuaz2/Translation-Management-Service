<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Translation;
use App\Models\Language;
use App\Models\Tag;

class SeedTranslationsCommand extends Command
{
    protected $signature = 'translations:seed {count=100000}';
    protected $description = 'Seed translations table with test data';

    public function handle()
    {
        $count = $this->argument('count');
        
        Translation::factory()
            ->count($count)
            ->create()
            ->each(function ($translation) {
                $translation->tags()->attach(
                    Tag::inRandomOrder()->limit(rand(1, 3))->pluck('id')
                );
            });
            
        $this->info("Successfully seeded {$count} translations");
    }
} 
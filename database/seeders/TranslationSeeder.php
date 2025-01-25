<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Tag;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $languages = Language::all();
        $tags = Tag::all();
        $batchSize = 1000; // Insert in chunks to avoid memory issues
        $totalRecords = 100000; // 100k records as per requirement

        $this->command->info('Starting to seed translations...');
        $this->command->getOutput()->progressStart($totalRecords);

        for ($i = 0; $i < $totalRecords; $i += $batchSize) {
            $translations = [];
            
            for ($j = 0; $j < $batchSize && ($i + $j) < $totalRecords; $j++) {
                $currentIndex = $i + $j;
                
                foreach ($languages as $language) {
                    $translation = Translation::create([
                        'key' => "key.translation.{$currentIndex}",
                        'value' => $this->generateDummyTranslation($language->code, $currentIndex),
                        'language_id' => $language->id,
                    ]);

                    // Randomly assign 1-3 tags to each translation
                    $randomTags = $tags->random(rand(1, 3));
                    $translation->tags()->attach($randomTags);
                }
                
                $this->command->getOutput()->progressAdvance();
            }
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info('Translations seeded successfully!');
    }

    private function generateDummyTranslation(string $languageCode, int $index): string
    {
        $prefixes = [
            'en' => 'Welcome to',
            'es' => 'Bienvenido a',
            'fr' => 'Bienvenue à',
            'de' => 'Willkommen bei',
            'it' => 'Benvenuto a',
        ];

        $suffixes = [
            'en' => ['our website', 'the application', 'the platform', 'the dashboard'],
            'es' => ['nuestro sitio web', 'la aplicación', 'la plataforma', 'el panel'],
            'fr' => ['notre site web', 'l\'application', 'la plateforme', 'le tableau de bord'],
            'de' => ['unsere Website', 'die Anwendung', 'die Plattform', 'das Dashboard'],
            'it' => ['il nostro sito web', 'l\'applicazione', 'la piattaforma', 'il cruscotto'],
        ];

        $prefix = $prefixes[$languageCode] ?? $prefixes['en'];
        $suffix = $suffixes[$languageCode][array_rand($suffixes[$languageCode])] ?? $suffixes['en'][0];

        return "{$prefix} {$suffix} {$index}";
    }
} 
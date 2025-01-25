<?php

namespace Tests\Performance;

use App\Models\Translation;
use App\Models\Language;
use Database\Seeders\TestDataSeeder;

class TranslationPerformanceTest extends PerformanceTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(TestDataSeeder::class);
    }

    public function test_translation_list_performance()
    {
        $this->assertResponseTime(function () {
            $response = $this->getJson('/api/v1/translations?locale=en');
            $response->assertStatus(200);
        }, 300);
    }

    public function test_translation_search_performance()
    {
        $this->assertResponseTime(function () {
            $response = $this->getJson('/api/v1/translations/search?query=welcome&locale=en');
            $response->assertStatus(200);
        }, 200);
    }

    public function test_translation_export_memory_usage()
    {
        $this->assertMemoryUsage(function () {
            $response = $this->getJson('/api/v1/translations/export?locale=en');
            $response->assertStatus(200);
        }, 50);
    }

    public function test_translation_creation_query_count()
    {
        $this->assertQueryCount(function () {
            $response = $this->postJson('/api/v1/translations', [
                'key' => 'test.key',
                'value' => 'Test Value',
                'locale' => 'en',
                'tags' => ['test']
            ]);
            $response->assertStatus(201);
        }, 5);
    }
} 
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('translations', function (Blueprint $table) {
            // Only add indexes, foreign key already exists
            $table->index(['language_id', 'key']);
            $table->fullText(['key', 'value']);
        });

        Schema::table('tag_translation', function (Blueprint $table) {
            $table->index(['translation_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::table('translations', function (Blueprint $table) {
            // Only drop indexes, leave foreign key intact
            $table->dropIndex(['language_id', 'key']);
            $table->dropFullText(['key', 'value']);
        });

        Schema::table('tag_translation', function (Blueprint $table) {
            $table->dropIndex(['translation_id', 'tag_id']);
        });
    }
};
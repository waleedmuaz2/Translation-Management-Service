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
            // Drop existing indexes if they exist
            if (Schema::hasIndex('translations', 'translations_language_id_key_index')) {
                $table->dropIndex('translations_language_id_key_index');
            }
            if (Schema::hasIndex('translations', 'translations_key_value_fulltext')) {
                $table->dropFullText('translations_key_value_fulltext');
            }

            // Add new indexes with unique names
            $table->index(['language_id', 'key'], 'translations_lang_key_composite_idx');
            $table->fullText(['key', 'value'], 'translations_key_value_fulltext_idx');
        });

        Schema::table('tag_translation', function (Blueprint $table) {
            if (Schema::hasIndex('tag_translation', 'tag_translation_composite_idx')) {
                $table->dropIndex('tag_translation_composite_idx');
            }
            
            // Add new index with unique name
            $table->index(['translation_id', 'tag_id'], 'tag_translation_composite_idx');
        });
    }

    public function down(): void
    {
        Schema::table('tag_translation', function (Blueprint $table) {
            $table->dropIndex('tag_translation_composite_idx');
        });

        Schema::table('translations', function (Blueprint $table) {
            // First drop the foreign key constraint
            $table->dropForeign(['language_id']);
            
            // Then drop the indexes
            $table->dropIndex('translations_lang_key_composite_idx');
            $table->dropFullText('translations_key_value_fulltext_idx');
            
            // Re-add the foreign key constraint
            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');
        });
    }
};
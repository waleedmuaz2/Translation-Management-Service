<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TranslationRepository
{
    public function __construct(
        private readonly Translation $model
    ) {}

    public function findByLocaleAndTags(string $locale, array $tags = []): Collection
    {
        return $this->model->query()
            ->select(['translations.id', 'translations.key', 'translations.value'])
            ->with(['tags:id,name'])
            ->byLocale($locale)
            ->byTags($tags)
            ->join('languages', 'translations.language_id', '=', 'languages.id')
            ->orderBy('translations.key')
            ->get();
    }

    public function findForExport(string $locale, array $tags = []): Collection
    {
        return $this->model->query()
            ->select(['translations.key', 'translations.value'])
            ->byLocale($locale)
            ->byTags($tags)
            ->join('languages', 'translations.language_id', '=', 'languages.id')
            ->orderBy('translations.key')
            ->cursor()
            ->collect();
    }

    public function search(string $query, ?string $locale = null, array $tags = []): Collection
    {
        $searchTerm = str_replace(['%', '_'], ['\%', '\_'], $query);
        
        return $this->model->query()
            ->select(['translations.id', 'translations.key', 'translations.value'])
            ->when($locale, fn($q) => $q->byLocale($locale))
            ->byTags($tags)
            ->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(translations.key) LIKE LOWER(?)', ["%{$searchTerm}%"])
                  ->orWhereRaw('LOWER(translations.value) LIKE LOWER(?)', ["%{$searchTerm}%"]);
            })
            ->limit(100)
            ->get();
    }
} 
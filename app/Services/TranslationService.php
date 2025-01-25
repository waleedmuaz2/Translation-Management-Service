<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\TranslationRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class TranslationService
{
    private const CACHE_TTL = 3600; // 1 hour

    public function __construct(
        private readonly TranslationRepository $repository
    ) {}

    public function getTranslations(string $locale, array $tags = []): Collection
    {
        $cacheKey = "translations:{$locale}:" . md5(json_encode($tags));
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($locale, $tags) {
            return $this->repository->findByLocaleAndTags($locale, $tags);
        });
    }

    public function getTranslationsForExport(string $locale, array $tags = []): array
    {
        return $this->repository->findForExport($locale, $tags)
            ->pluck('value', 'key')
            ->toArray();
    }

    public function searchTranslations(string $query, ?string $locale = null, array $tags = []): Collection
    {
        return $this->repository->search($query, $locale, $tags);
    }
}
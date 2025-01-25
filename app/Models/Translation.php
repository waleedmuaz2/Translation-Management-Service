<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Translation extends Model
{
    protected $fillable = [
        'key',
        'value',
        'language_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeByLocale(Builder $query, string $locale): Builder
    {
        return $query->whereHas('language', function ($q) use ($locale) {
            $q->where('code', $locale);
        });
    }

    public function scopeByTags(Builder $query, array $tags): Builder
    {
        return $query->when(!empty($tags), function ($q) use ($tags) {
            $q->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        });
    }
}
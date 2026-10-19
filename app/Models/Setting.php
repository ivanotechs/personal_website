<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use App\Support\PublicMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    use HasTranslations;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'nationality' => 'array',
            'role_label' => 'array',
            'tagline' => 'array',
            'about_short' => 'array',
            'about_long' => 'array',
            'availability' => 'array',
            'seo_title' => 'array',
            'seo_description' => 'array',
            'seo_keywords' => 'array',
            'highlights' => 'array',
            'spoken_languages' => 'array',
        ];
    }

    public static function current(): ?self
    {
        if (! Schema::hasTable('settings')) {
            return null;
        }

        $id = Cache::remember('settings.current', 3600, fn () => static::query()->value('id'));

        return $id ? static::query()->find($id) : null;
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::forgetCache());
        static::deleted(fn () => static::forgetCache());
    }

    public static function forgetCache(): void
    {
        Cache::forget('settings.current');
    }

    public function mediaUrl(?string $path): ?string
    {
        return PublicMedia::url($path);
    }

    public function logoUrl(): ?string
    {
        return $this->mediaUrl($this->logo_path);
    }

    public function portraitUrl(): ?string
    {
        return $this->mediaUrl($this->portrait_path);
    }
}

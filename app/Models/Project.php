<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasTranslations;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'stack' => 'array',
            'title' => 'array',
            'summary' => 'array',
            'body' => 'array',
            'featured' => 'boolean',
            'published' => 'boolean',
            'icon_light' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true);
    }

    public function iconUrl(): ?string
    {
        return $this->icon_path ? url('storage/'.$this->icon_path) : null;
    }
}

<?php

namespace App\Models\Concerns;

trait HasTranslations
{
    public function text(string $field, ?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $value = $this->getAttribute($field);

        if (! is_array($value)) {
            return (string) ($value ?? '');
        }

        $fallback = (string) config('app.fallback_locale', 'en');

        return (string) ($value[$locale] ?? $value[$fallback] ?? (reset($value) ?: ''));
    }
}

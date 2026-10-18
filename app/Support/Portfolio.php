<?php

namespace App\Support;

class Portfolio
{
    public const LOCALES = ['en', 'de', 'fr'];

    public static function projects(): array
    {
        return [
            [
                'slug' => 'fleet-console',
                'category' => 'automotive',
                'year' => '2026',
                'stack' => ['Laravel', 'Livewire', 'MQTT'],
                'hue' => 'from-sky-400/50 to-blue-700/20',
            ],
            [
                'slug' => 'diag-bridge',
                'category' => 'automotive',
                'year' => '2026',
                'stack' => ['PHP', 'REST', 'SQL'],
                'hue' => 'from-cyan-300/50 to-indigo-700/20',
            ],
            [
                'slug' => 'studio-api',
                'category' => 'web',
                'year' => '2025',
                'stack' => ['Laravel', 'JSON', 'SQLite'],
                'hue' => 'from-violet-400/45 to-blue-800/20',
            ],
            [
                'slug' => 'interface-kit',
                'category' => 'web',
                'year' => '2025',
                'stack' => ['Alpine.js', 'Tailwind', 'Blade'],
                'hue' => 'from-blue-300/40 to-slate-700/30',
            ],
        ];
    }

    public static function find(string $slug): array
    {
        $project = collect(self::projects())->firstWhere('slug', $slug);

        abort_if($project === null, 404);

        return $project;
    }

    public static function neighbors(string $slug): array
    {
        $projects = self::projects();
        $index = array_search($slug, array_column($projects, 'slug'), true);

        return [
            'previous' => $index > 0 ? $projects[$index - 1] : null,
            'next' => $index !== false && isset($projects[$index + 1]) ? $projects[$index + 1] : null,
        ];
    }

    public static function services(): array
    {
        return [
            ['key' => 'web', 'icon' => 'window'],
            ['key' => 'auto', 'icon' => 'car'],
            ['key' => 'api', 'icon' => 'api'],
            ['key' => 'systems', 'icon' => 'chip'],
            ['key' => 'ui', 'icon' => 'pen'],
            ['key' => 'tools', 'icon' => 'tool'],
        ];
    }

    public static function principles(): array
    {
        return [
            ['key' => 'clarity', 'icon' => 'spark'],
            ['key' => 'care', 'icon' => 'target'],
            ['key' => 'systems', 'icon' => 'chip'],
            ['key' => 'learning', 'icon' => 'globe'],
        ];
    }
}

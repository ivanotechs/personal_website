<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use App\Support\LocaleResolver;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /en/admin',
            'Disallow: /de/admin',
            'Disallow: /fr/admin',
            'Sitemap: '.url('/sitemap.xml'),
        ];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain']);
    }

    public function sitemap(): Response
    {
        $settings = Setting::current();
        $urls = [];

        foreach (LocaleResolver::ALL as $locale) {
            foreach (['home', 'about', 'cv', 'projects', 'contact'] as $name) {
                $urls[] = [
                    'loc' => $name === 'home' ? url('/'.$locale) : route($name, ['locale' => $locale]),
                    'changefreq' => 'weekly',
                ];
            }

            foreach (Project::published()->orderBy('sort')->get() as $project) {
                $urls[] = [
                    'loc' => route('projects.show', ['locale' => $locale, 'project' => $project->slug]),
                    'changefreq' => 'monthly',
                ];
            }
        }

        $xml = view('seo.sitemap', [
            'urls' => $urls,
            'site' => $settings,
        ])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}

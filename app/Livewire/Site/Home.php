<?php

namespace App\Livewire\Site;

use App\Livewire\Page;
use App\Models\Project;

class Home extends Page
{
    protected function viewName(): string
    {
        return 'livewire.site.home';
    }

    protected function pageKey(): ?string
    {
        return 'home';
    }

    protected function viewData(): array
    {
        return [
            'projects' => Project::published()->where('featured', true)->orderBy('sort')->take(6)->get(),
        ];
    }
}

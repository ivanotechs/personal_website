<?php

namespace App\Livewire\Site;

use App\Livewire\Page;
use App\Models\Project;

class Projects extends Page
{
    protected function viewName(): string
    {
        return 'livewire.site.projects';
    }

    protected function pageKey(): ?string
    {
        return 'projects';
    }

    protected function viewData(): array
    {
        $projects = Project::published()->orderBy('sort')->get();

        return [
            'projects' => $projects,
            'categories' => $projects->pluck('category')->unique()->values(),
        ];
    }
}

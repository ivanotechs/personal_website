<?php

namespace App\Livewire\Site;

use App\Livewire\Page;
use App\Models\Project as ProjectModel;
use App\Models\Setting;

class ProjectShow extends Page
{
    public string $slug = '';

    public function mount(string $project): void
    {
        $this->slug = $project;
    }

    protected function viewName(): string
    {
        return 'livewire.site.project-show';
    }

    protected function title(): string
    {
        $project = $this->record();

        return $project->text('title').' — '.(Setting::current()?->site_name ?? 'Ivanotechs');
    }

    protected function description(): string
    {
        return $this->record()->text('summary');
    }

    protected function viewData(): array
    {
        $project = $this->record();
        $ordered = ProjectModel::published()->orderBy('sort')->get();
        $index = $ordered->search(fn (ProjectModel $item) => $item->id === $project->id);

        return [
            'project' => $project,
            'neighbors' => [
                'previous' => $index > 0 ? $ordered[$index - 1] : null,
                'next' => $index !== false && isset($ordered[$index + 1]) ? $ordered[$index + 1] : null,
            ],
        ];
    }

    private function record(): ProjectModel
    {
        return ProjectModel::published()->where('slug', $this->slug)->firstOrFail();
    }
}

<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\Project;

class ProjectIndex extends Page
{
    public function delete(int $id): void
    {
        Project::query()->whereKey($id)->delete();
        $this->toast(__('site.toast.deleted'));
    }

    protected function viewName(): string
    {
        return 'livewire.admin.project-index';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.projects').' — Ivanotechs';
    }

    protected function viewData(): array
    {
        return ['items' => Project::query()->orderBy('sort')->get()];
    }
}

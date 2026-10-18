<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;

class Dashboard extends Page
{
    protected function viewName(): string
    {
        return 'livewire.admin.dashboard';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.dashboard').' — Ivanotechs';
    }

    protected function viewData(): array
    {
        return [
            'counts' => [
                'projects' => Project::query()->count(),
                'experience' => Experience::query()->count(),
                'education' => Education::query()->count(),
                'skills' => Skill::query()->count(),
                'messages' => ContactMessage::query()->count(),
                'unread' => ContactMessage::query()->whereNull('read_at')->count(),
            ],
        ];
    }
}

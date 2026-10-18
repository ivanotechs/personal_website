<?php

namespace App\Livewire\Site;

use App\Livewire\Page;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;

class Cv extends Page
{
    protected function viewName(): string
    {
        return 'livewire.site.cv';
    }

    protected function pageKey(): ?string
    {
        return 'cv';
    }

    protected function viewData(): array
    {
        return [
            'experiences' => Experience::query()->orderBy('sort')->get(),
            'educations' => Education::query()->orderBy('sort')->get(),
            'skills' => Skill::query()->orderBy('sort')->get()->groupBy(fn (Skill $skill) => $skill->text('group_label')),
        ];
    }
}

<?php

namespace App\Livewire\Site;

use App\Livewire\Page;

class About extends Page
{
    protected function viewName(): string
    {
        return 'livewire.site.about';
    }

    protected function pageKey(): ?string
    {
        return 'about';
    }
}

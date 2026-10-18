<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\Setting;

class Themes extends Page
{
    public function save(string $accent): void
    {
        abort_unless(preg_match('/^#[0-9a-fA-F]{6}$/', $accent) === 1, 422);

        Setting::query()->firstOrFail()->update(['accent' => $accent]);
        $this->toast(__('site.toast.accent'));
        $this->js("localStorage.setItem('accent', ".json_encode($accent).'); document.documentElement.style.setProperty("--accent", '.json_encode($accent).');');
    }

    protected function viewName(): string
    {
        return 'livewire.admin.themes';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.themes').' — Ivanotechs';
    }
}

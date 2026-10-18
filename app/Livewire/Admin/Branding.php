<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\Setting;
use Livewire\WithFileUploads;

class Branding extends Page
{
    use WithFileUploads;

    public string $site_name = '';

    public string $accent = '#2f7cff';

    public $logo;

    public bool $saved = false;

    public function mount(): void
    {
        $setting = Setting::query()->firstOrFail();
        $this->site_name = $setting->site_name;
        $this->accent = $setting->accent ?: '#2f7cff';
    }

    public function save(): void
    {
        $this->validate([
            'site_name' => ['required', 'string', 'max:80'],
            'accent' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ]);

        $setting = Setting::query()->firstOrFail();
        $data = [
            'site_name' => $this->site_name,
            'accent' => $this->accent,
        ];

        if ($this->logo) {
            $data['logo_path'] = $this->logo->store('brand', 'public');
        }

        $setting->update($data);
        $this->saved = true;
        $this->toast(__('site.toast.saved'));
        $this->js("localStorage.setItem('accent', ".json_encode($this->accent).'); document.documentElement.style.setProperty("--accent", '.json_encode($this->accent).');');
    }

    protected function viewName(): string
    {
        return 'livewire.admin.branding';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.branding').' — Ivanotechs';
    }
}

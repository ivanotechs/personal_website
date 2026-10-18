<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\PageSeo;
use App\Models\Setting;
use Livewire\WithFileUploads;

class Profile extends Page
{
    use WithFileUploads;

    public string $full_name = '';

    public string $handle = '';

    public string $public_email = '';

    public string $phone = '';

    public string $address = '';

    public string $city = '';

    public string $country = '';

    public ?string $birth_date = null;

    public string $github_url = '';

    public string $linkedin_url = '';

    public string $xing_url = '';

    public string $website_url = '';

    public string $x_url = '';

    public array $nationality = ['en' => '', 'de' => '', 'fr' => ''];

    public array $role_label = ['en' => '', 'de' => '', 'fr' => ''];

    public array $tagline = ['en' => '', 'de' => '', 'fr' => ''];

    public array $about_short = ['en' => '', 'de' => '', 'fr' => ''];

    public array $about_long = ['en' => '', 'de' => '', 'fr' => ''];

    public array $availability = ['en' => '', 'de' => '', 'fr' => ''];

    public array $seo_title = ['en' => '', 'de' => '', 'fr' => ''];

    public array $seo_description = ['en' => '', 'de' => '', 'fr' => ''];

    public array $seo_keywords = ['en' => '', 'de' => '', 'fr' => ''];

    public array $highlights = [];

    public array $spoken_languages = [];

    public array $pages = [];

    public $portrait;

    public bool $saved = false;

    public function mount(): void
    {
        $setting = Setting::query()->firstOrFail();

        foreach (['full_name', 'handle', 'public_email', 'phone', 'address', 'city', 'country', 'github_url', 'linkedin_url', 'xing_url', 'website_url', 'x_url'] as $field) {
            $this->{$field} = (string) ($setting->{$field} ?? '');
        }

        $this->birth_date = $setting->birth_date?->format('Y-m-d');

        foreach (['nationality', 'role_label', 'tagline', 'about_short', 'about_long', 'availability', 'seo_title', 'seo_description', 'seo_keywords'] as $field) {
            $this->{$field} = array_merge(['en' => '', 'de' => '', 'fr' => ''], $setting->{$field} ?? []);
        }

        $this->highlights = $setting->highlights ?? [];
        $this->spoken_languages = $setting->spoken_languages ?? [];

        foreach (['home', 'about', 'cv', 'projects', 'contact'] as $key) {
            $seo = PageSeo::for($key);
            $this->pages[$key] = [
                'title' => array_merge(['en' => '', 'de' => '', 'fr' => ''], $seo?->title ?? []),
                'description' => array_merge(['en' => '', 'de' => '', 'fr' => ''], $seo?->description ?? []),
            ];
        }
    }

    public function addHighlight(): void
    {
        $this->highlights[] = [
            'icon' => 'spark',
            'title' => ['en' => '', 'de' => '', 'fr' => ''],
            'body' => ['en' => '', 'de' => '', 'fr' => ''],
        ];
        $this->toast(__('site.toast.added'), 'info');
    }

    public function removeHighlight(int $index): void
    {
        unset($this->highlights[$index]);
        $this->highlights = array_values($this->highlights);
        $this->toast(__('site.toast.removed'), 'info');
    }

    public function addLanguage(): void
    {
        $this->spoken_languages[] = [
            'name' => ['en' => '', 'de' => '', 'fr' => ''],
            'level' => ['en' => '', 'de' => '', 'fr' => ''],
        ];
        $this->toast(__('site.toast.added'), 'info');
    }

    public function removeLanguage(int $index): void
    {
        unset($this->spoken_languages[$index]);
        $this->spoken_languages = array_values($this->spoken_languages);
        $this->toast(__('site.toast.removed'), 'info');
    }

    public function save(): void
    {
        $this->validate([
            'full_name' => ['required', 'string', 'max:160'],
            'handle' => ['required', 'string', 'max:80'],
            'public_email' => ['required', 'email', 'max:160'],
            'portrait' => ['nullable', 'image', 'max:4096'],
        ]);

        $setting = Setting::query()->firstOrFail();
        $data = [
            'full_name' => $this->full_name,
            'handle' => $this->handle,
            'public_email' => $this->public_email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'birth_date' => $this->birth_date ?: null,
            'github_url' => $this->github_url,
            'linkedin_url' => $this->linkedin_url,
            'xing_url' => $this->xing_url,
            'website_url' => $this->website_url,
            'x_url' => $this->x_url,
            'nationality' => $this->nationality,
            'role_label' => $this->role_label,
            'tagline' => $this->tagline,
            'about_short' => $this->about_short,
            'about_long' => $this->about_long,
            'availability' => $this->availability,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'seo_keywords' => $this->seo_keywords,
            'highlights' => $this->highlights,
            'spoken_languages' => $this->spoken_languages,
        ];

        if ($this->portrait) {
            $data['portrait_path'] = $this->portrait->store('brand', 'public');
        }

        $setting->update($data);

        foreach ($this->pages as $key => $page) {
            PageSeo::query()->updateOrCreate(['key' => $key], $page);
        }

        $this->saved = true;
        $this->portrait = null;
        $this->toast(__('site.toast.saved'));
    }

    protected function viewName(): string
    {
        return 'livewire.admin.profile';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.profile').' — Ivanotechs';
    }
}

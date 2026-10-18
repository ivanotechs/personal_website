<?php

namespace App\Livewire;

use App\Models\PageSeo;
use App\Models\Setting;
use Livewire\Component;

abstract class Page extends Component
{
    abstract protected function viewName(): string;

    protected function pageKey(): ?string
    {
        return null;
    }

    protected function title(): string
    {
        $page = $this->pageKey() ? PageSeo::for($this->pageKey())?->text('title') : null;

        if ($page) {
            return $page;
        }

        return Setting::current()?->text('seo_title') ?: (Setting::current()?->site_name ?? 'Ivanotechs');
    }

    protected function description(): string
    {
        if ($this->pageKey()) {
            $page = PageSeo::for($this->pageKey());
            if ($page) {
                return $page->text('description');
            }
        }

        return Setting::current()?->text('seo_description') ?? '';
    }

    protected function layout(): string
    {
        return 'layouts.site';
    }

    public function render()
    {
        return view($this->viewName(), $this->viewData())
            ->layout($this->layout(), [
                'title' => $this->title(),
                'description' => $this->description(),
            ]);
    }

    protected function viewData(): array
    {
        return [];
    }
}

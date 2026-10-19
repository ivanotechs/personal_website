<?php

namespace App\Livewire\Site;

use App\Livewire\Page;

class ContactSent extends Page
{
    public function mount(): void
    {
        if (! session()->pull('contact.sent')) {
            $this->redirectRoute('contact', ['locale' => app()->getLocale()], navigate: true);
        }
    }

    protected function viewName(): string
    {
        return 'livewire.site.contact-sent';
    }

    protected function title(): string
    {
        return __('site.contact.sent_title').' — Ivanotechs';
    }

    protected function description(): string
    {
        return __('site.contact.sent_body');
    }

    protected function shouldIndex(): bool
    {
        return false;
    }
}

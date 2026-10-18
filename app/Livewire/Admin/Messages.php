<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\ContactMessage;

class Messages extends Page
{
    public ?int $open = null;

    public function show(int $id): void
    {
        $message = ContactMessage::query()->findOrFail($id);
        $message->forceFill(['read_at' => $message->read_at ?? now()])->save();
        $this->open = $message->id;
    }

    public function remove(int $id): void
    {
        ContactMessage::query()->whereKey($id)->delete();

        if ($this->open === $id) {
            $this->open = null;
        }
    }

    protected function viewName(): string
    {
        return 'livewire.admin.messages';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.messages').' — Ivanotechs';
    }

    protected function viewData(): array
    {
        return [
            'items' => ContactMessage::query()->latest()->get(),
            'current' => $this->open ? ContactMessage::query()->find($this->open) : null,
        ];
    }
}

<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\Experience;

class Experiences extends Page
{
    public ?int $editing = null;

    public string $company = '';

    public string $location = '';

    public ?string $start_date = null;

    public ?string $end_date = null;

    public bool $is_current = false;

    public int $sort = 1;

    public array $role = ['en' => '', 'de' => '', 'fr' => ''];

    public array $summary = ['en' => '', 'de' => '', 'fr' => ''];

    public function edit(int $id): void
    {
        $item = Experience::query()->findOrFail($id);
        $this->editing = $item->id;
        $this->company = $item->company;
        $this->location = (string) $item->location;
        $this->start_date = $item->start_date?->format('Y-m-d');
        $this->end_date = $item->end_date?->format('Y-m-d');
        $this->is_current = (bool) $item->is_current;
        $this->sort = (int) $item->sort;
        $this->role = array_merge(['en' => '', 'de' => '', 'fr' => ''], $item->role ?? []);
        $this->summary = array_merge(['en' => '', 'de' => '', 'fr' => ''], $item->summary ?? []);
        $this->toast(__('site.toast.opened', ['name' => $item->company]), 'info');
    }

    public function createNew(bool $silent = false): void
    {
        $this->reset(['editing', 'company', 'location', 'start_date', 'end_date', 'is_current']);
        $this->sort = (int) Experience::query()->max('sort') + 1;
        $this->role = ['en' => '', 'de' => '', 'fr' => ''];
        $this->summary = ['en' => '', 'de' => '', 'fr' => ''];

        if (! $silent) {
            $this->toast(__('site.toast.created'), 'info');
        }
    }

    public function save(): void
    {
        $this->validate([
            'company' => ['required', 'string', 'max:160'],
            'role.en' => ['required', 'string'],
            'summary.en' => ['required', 'string'],
        ]);

        $data = [
            'company' => $this->company,
            'location' => $this->location,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->is_current ? null : ($this->end_date ?: null),
            'is_current' => $this->is_current,
            'sort' => $this->sort,
            'role' => $this->role,
            'summary' => $this->summary,
        ];

        if ($this->editing) {
            Experience::query()->whereKey($this->editing)->update($data);
        } else {
            Experience::query()->create($data);
        }

        $this->createNew(true);
        $this->toast(__('site.toast.saved'));
    }

    public function delete(int $id): void
    {
        Experience::query()->whereKey($id)->delete();

        if ($this->editing === $id) {
            $this->createNew(true);
        }

        $this->toast(__('site.toast.deleted'));
    }

    protected function viewName(): string
    {
        return 'livewire.admin.experiences';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.experience').' — Ivanotechs';
    }

    protected function viewData(): array
    {
        return [
            'items' => Experience::query()->orderBy('sort')->get(),
        ];
    }
}

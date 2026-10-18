<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\Education;

class Educations extends Page
{
    public ?int $editing = null;

    public string $school = '';

    public string $location = '';

    public ?string $start_date = null;

    public ?string $end_date = null;

    public bool $is_current = false;

    public int $sort = 1;

    public array $title = ['en' => '', 'de' => '', 'fr' => ''];

    public array $summary = ['en' => '', 'de' => '', 'fr' => ''];

    public function edit(int $id): void
    {
        $item = Education::query()->findOrFail($id);
        $this->editing = $item->id;
        $this->school = (string) $item->school;
        $this->location = (string) $item->location;
        $this->start_date = $item->start_date?->format('Y-m-d');
        $this->end_date = $item->end_date?->format('Y-m-d');
        $this->is_current = (bool) $item->is_current;
        $this->sort = (int) $item->sort;
        $this->title = array_merge(['en' => '', 'de' => '', 'fr' => ''], $item->title ?? []);
        $this->summary = array_merge(['en' => '', 'de' => '', 'fr' => ''], $item->summary ?? []);
        $this->toast(__('site.toast.opened', ['name' => $item->text('title')]), 'info');
    }

    public function createNew(bool $silent = false): void
    {
        $this->reset(['editing', 'school', 'location', 'start_date', 'end_date', 'is_current']);
        $this->sort = (int) Education::query()->max('sort') + 1;
        $this->title = ['en' => '', 'de' => '', 'fr' => ''];
        $this->summary = ['en' => '', 'de' => '', 'fr' => ''];

        if (! $silent) {
            $this->toast(__('site.toast.created'), 'info');
        }
    }

    public function save(): void
    {
        $this->validate(['title.en' => ['required', 'string']]);

        $data = [
            'school' => $this->school,
            'location' => $this->location,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->is_current ? null : ($this->end_date ?: null),
            'is_current' => $this->is_current,
            'sort' => $this->sort,
            'title' => $this->title,
            'summary' => $this->summary,
        ];

        if ($this->editing) {
            Education::query()->whereKey($this->editing)->update($data);
        } else {
            Education::query()->create($data);
        }

        $this->createNew(true);
        $this->toast(__('site.toast.saved'));
    }

    public function delete(int $id): void
    {
        Education::query()->whereKey($id)->delete();

        if ($this->editing === $id) {
            $this->createNew(true);
        }

        $this->toast(__('site.toast.deleted'));
    }

    protected function viewName(): string
    {
        return 'livewire.admin.educations';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.education').' — Ivanotechs';
    }

    protected function viewData(): array
    {
        return ['items' => Education::query()->orderBy('sort')->get()];
    }
}

<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\Skill;

class Skills extends Page
{
    public ?int $editing = null;

    public string $name = '';

    public int $sort = 1;

    public array $group_label = ['en' => '', 'de' => '', 'fr' => ''];

    public function edit(int $id): void
    {
        $item = Skill::query()->findOrFail($id);
        $this->editing = $item->id;
        $this->name = $item->name;
        $this->sort = (int) $item->sort;
        $this->group_label = array_merge(['en' => '', 'de' => '', 'fr' => ''], $item->group_label ?? []);
    }

    public function createNew(): void
    {
        $this->reset(['editing', 'name']);
        $this->sort = (int) Skill::query()->max('sort') + 1;
        $this->group_label = ['en' => '', 'de' => '', 'fr' => ''];
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:80'],
            'group_label.en' => ['required', 'string'],
        ]);

        $data = [
            'name' => $this->name,
            'sort' => $this->sort,
            'group_label' => $this->group_label,
        ];

        if ($this->editing) {
            Skill::query()->whereKey($this->editing)->update($data);
        } else {
            Skill::query()->create($data);
        }

        $this->createNew();
    }

    public function delete(int $id): void
    {
        Skill::query()->whereKey($id)->delete();

        if ($this->editing === $id) {
            $this->createNew();
        }
    }

    protected function viewName(): string
    {
        return 'livewire.admin.skills';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.skills').' — Ivanotechs';
    }

    protected function viewData(): array
    {
        return ['items' => Skill::query()->orderBy('sort')->get()];
    }
}

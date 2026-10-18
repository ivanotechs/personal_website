<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use App\Models\Project;
use App\Support\SiteIcon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectForm extends Page
{
    public ?int $projectId = null;

    public string $slug = '';

    public string $category = 'web';

    public string $year = '';

    public string $url = '';

    public string $github_url = '';

    public bool $featured = false;

    public bool $published = true;

    public int $sort = 1;

    public string $stack = '';

    public array $title = ['en' => '', 'de' => '', 'fr' => ''];

    public array $summary = ['en' => '', 'de' => '', 'fr' => ''];

    public array $body = ['en' => '', 'de' => '', 'fr' => ''];

    public function mount(?int $project = null): void
    {
        if (! $project) {
            $this->sort = (int) Project::query()->max('sort') + 1;

            return;
        }

        $item = Project::query()->findOrFail($project);
        $this->projectId = $item->id;
        $this->slug = $item->slug;
        $this->category = $item->category;
        $this->year = (string) ($item->year ?? '');
        $this->url = (string) $item->url;
        $this->github_url = (string) $item->github_url;
        $this->featured = (bool) $item->featured;
        $this->published = (bool) $item->published;
        $this->sort = (int) $item->sort;
        $this->stack = implode(', ', $item->stack ?? []);
        $this->title = array_merge(['en' => '', 'de' => '', 'fr' => ''], $item->title ?? []);
        $this->summary = array_merge(['en' => '', 'de' => '', 'fr' => ''], $item->summary ?? []);
        $this->body = array_merge(['en' => '', 'de' => '', 'fr' => ''], $item->body ?? []);
    }

    public function save(): void
    {
        if ($this->slug === '' && $this->title['en'] !== '') {
            $this->slug = Str::slug($this->title['en']);
        }

        $this->validate([
            'slug' => ['required', 'string', 'max:160', Rule::unique('projects', 'slug')->ignore($this->projectId)],
            'category' => ['required', 'in:web,mobile,systems,data,platform'],
            'title.en' => ['required', 'string'],
            'summary.en' => ['required', 'string'],
            'body.en' => ['required', 'string'],
        ]);

        $data = [
            'slug' => $this->slug,
            'category' => $this->category,
            'year' => $this->year !== '' ? (int) $this->year : null,
            'url' => $this->url ?: null,
            'github_url' => $this->github_url ?: null,
            'featured' => $this->featured,
            'published' => $this->published,
            'sort' => $this->sort,
            'stack' => array_values(array_filter(array_map('trim', explode(',', $this->stack)))),
            'title' => $this->title,
            'summary' => $this->summary,
            'body' => $this->body,
        ];

        if ($this->projectId) {
            $record = Project::query()->findOrFail($this->projectId);
            $record->update($data);
        } else {
            $record = Project::query()->create($data);
        }

        try {
            app(SiteIcon::class)->store($record->fresh());
        } catch (\Throwable $exception) {
            report($exception);
        }

        $this->redirectRoute('admin.projects.index', ['locale' => app()->getLocale()], navigate: true);
    }

    protected function viewName(): string
    {
        return 'livewire.admin.project-form';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return ($this->projectId ? __('site.meta.project_edit') : __('site.meta.project_new')).' — Ivanotechs';
    }
}

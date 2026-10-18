<div class="mx-auto max-w-4xl">
    <h1 class="text-3xl font-extrabold">{{ $projectId ? __('site.meta.project_edit') : __('site.meta.project_new') }}</h1>
    <form wire:submit="save" class="surface mt-6 grid gap-4 p-5">
        <div class="grid gap-4 md:grid-cols-2">
            <label class="grid gap-2 text-sm font-semibold">Slug<input class="field" wire:model="slug"></label>
            <label class="grid gap-2 text-sm font-semibold">Category
                <select class="field" wire:model="category">
                    @foreach (['web', 'mobile', 'systems', 'data', 'platform'] as $category)
                        <option value="{{ $category }}">{{ __('site.projects.filters.'.$category) }}</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-2 text-sm font-semibold">Year<input class="field" wire:model="year"></label>
            <label class="grid gap-2 text-sm font-semibold">Sort<input class="field" type="number" wire:model="sort"></label>
            <label class="grid gap-2 text-sm font-semibold">URL<input class="field" wire:model="url"></label>
            <label class="grid gap-2 text-sm font-semibold">GitHub<input class="field" wire:model="github_url"></label>
        </div>
        <label class="grid gap-2 text-sm font-semibold">Stack, comma separated<textarea class="field" wire:model="stack"></textarea></label>
        <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" wire:model="featured"> Featured</label>
        <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" wire:model="published"> Published</label>
        <x-admin.locales label="Title" model="title" />
        <x-admin.locales label="Summary" model="summary" :area="true" />
        <x-admin.locales label="Body" model="body" :area="true" />
        @error('slug') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        <x-action-button type="submit" class="btn-primary w-fit" target="save">{{ __('site.admin.save') }}</x-action-button>
    </form>
</div>

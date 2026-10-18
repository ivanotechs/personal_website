<div>
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.projects') }}</h1>
        <a href="{{ route('admin.projects.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary" wire:navigate>{{ __('site.meta.project_new') }}</a>
    </div>
    <div class="mt-6 grid gap-3">
        @foreach ($items as $item)
            <article class="surface flex flex-wrap items-center justify-between gap-3 p-4">
                <div>
                    <h2 class="font-bold">{{ $item->text('title') }}</h2>
                    <p class="text-sm text-muted">{{ $item->category }} · {{ $item->year }} @if (! $item->published) · hidden @endif</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.projects.edit', ['locale' => app()->getLocale(), 'project' => $item->id]) }}" class="btn btn-ghost" wire:navigate>Edit</a>
                    <button type="button" class="btn btn-ghost text-red-500" wire:click="delete({{ $item->id }})">Delete</button>
                </div>
            </article>
        @endforeach
    </div>
</div>

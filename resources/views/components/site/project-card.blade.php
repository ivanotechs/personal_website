@props(['project'])

<a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $project->slug]) }}" class="surface group flex h-full flex-col p-3 transition hover:-translate-y-0.5" wire:navigate>
    <div class="relative aspect-[16/10] overflow-hidden rounded-2xl bg-gradient-to-br from-sky-400/40 to-blue-800/30">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.28),transparent_42%)]"></div>
        @if ($project->iconUrl())
            <div class="absolute inset-x-0 top-5 grid place-items-center">
                <img src="{{ $project->iconUrl() }}" alt="" @class([
                    'size-16 rounded-2xl object-contain p-2 shadow-lg',
                    'bg-[#12151c]' => $project->icon_light,
                    'bg-white/95' => ! $project->icon_light,
                ])>
            </div>
        @endif
        <div class="absolute bottom-4 left-4 right-4 rounded-xl border border-white/15 bg-black/30 p-3 text-white backdrop-blur-md">
            <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-white/70">{{ __('site.projects.filters.'.$project->category) }}</p>
            <p class="mt-1 text-sm font-semibold">{{ $project->text('title') }}</p>
        </div>
    </div>
    <div class="flex flex-1 flex-col px-2 pb-2 pt-4">
        <p class="text-xs font-semibold text-muted">{{ $project->year }}</p>
        <h3 class="mt-1 text-lg font-bold tracking-tight">{{ $project->text('title') }}</h3>
        <p class="mt-2 flex-1 text-sm leading-6 text-muted">{{ $project->text('summary') }}</p>
        <span class="mt-4 grid size-10 place-items-center rounded-full bg-accent text-white">
            <x-icon name="arrow" class="size-4" />
        </span>
    </div>
</a>

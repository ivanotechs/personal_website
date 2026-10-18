@php($settings = $settings ?? null)
<a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="inline-flex min-w-0 items-center gap-3" wire:navigate>
    @if ($settings?->logoUrl())
        <img src="{{ $settings->logoUrl() }}" alt="{{ $settings->site_name }}" class="size-10 shrink-0 rounded-2xl object-cover">
    @else
        <span class="grid size-10 shrink-0 place-items-center rounded-2xl bg-accent text-sm font-extrabold text-white">I</span>
    @endif
    <span class="min-w-0 leading-tight">
        <span class="block truncate text-sm font-extrabold tracking-tight">{{ $settings->site_name ?? 'Ivanotechs' }}</span>
        <span class="hidden truncate text-xs text-muted sm:block">{{ $settings?->text('role_label') }}</span>
    </span>
</a>

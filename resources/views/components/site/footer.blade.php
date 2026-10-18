<footer class="no-print border-t border-line">
    <div class="mx-auto flex max-w-6xl flex-col gap-8 px-5 py-10 md:flex-row md:items-end md:justify-between">
        <div class="max-w-md">
            <x-site.logo />
            <p class="mt-4 text-sm leading-6 text-muted">{{ $settings?->text('about_short') }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-x-5 gap-y-3 text-sm font-semibold">
            <a href="{{ route('about', ['locale' => app()->getLocale()]) }}" class="text-muted hover:text-ink" wire:navigate>{{ __('site.nav.about') }}</a>
            <a href="{{ route('cv', ['locale' => app()->getLocale()]) }}" class="text-muted hover:text-ink" wire:navigate>{{ __('site.nav.cv') }}</a>
            <a href="{{ route('projects', ['locale' => app()->getLocale()]) }}" class="text-muted hover:text-ink" wire:navigate>{{ __('site.nav.projects') }}</a>
            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="text-muted hover:text-ink" wire:navigate>{{ __('site.nav.contact') }}</a>
            <a href="{{ route('admin.dashboard', ['locale' => app()->getLocale()]) }}" class="text-accent" wire:navigate>{{ __('site.footer.admin') }}</a>
        </div>
    </div>
    <div class="border-t border-line">
        <p class="mx-auto max-w-6xl px-5 py-4 text-xs text-muted">© {{ now()->year }} {{ $settings->site_name ?? 'Ivanotechs' }}</p>
    </div>
</footer>

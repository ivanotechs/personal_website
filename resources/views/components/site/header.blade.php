@php
    $links = [
        ['route' => 'home', 'label' => __('site.nav.home')],
        ['route' => 'about', 'label' => __('site.nav.about')],
        ['route' => 'cv', 'label' => __('site.nav.cv')],
        ['route' => 'projects', 'label' => __('site.nav.projects')],
        ['route' => 'contact', 'label' => __('site.nav.contact')],
    ];
@endphp

<header class="no-print sticky top-0 z-40 border-b border-line/80 bg-canvas/80 backdrop-blur-xl">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-4">
        <x-site.logo />

        <nav class="hidden items-center gap-1 lg:flex" aria-label="{{ __('site.nav.home') }}">
            @foreach ($links as $link)
                <a
                    href="{{ route($link['route'], ['locale' => app()->getLocale()]) }}"
                    wire:navigate
                    @class([
                        'rounded-xl px-3 py-2 text-sm font-semibold transition',
                        'bg-elevated text-ink shadow-sm' => request()->routeIs($link['route']) || ($link['route'] === 'contact' && request()->routeIs('contact.sent')),
                        'text-muted hover:text-ink' => ! (request()->routeIs($link['route']) || ($link['route'] === 'contact' && request()->routeIs('contact.sent'))),
                    ])
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex shrink-0 items-center gap-2">
            <div class="hidden items-center rounded-xl border border-line bg-elevated/70 p-1 sm:flex" role="group" aria-label="{{ __('site.nav.languages') }}">
                @foreach (['en', 'de', 'fr'] as $code)
                    <a
                        href="{{ route(request()->route()->getName(), array_merge(request()->route()->parameters(), ['locale' => $code])) }}"
                        wire:navigate
                        @click="$store.toast.hold(@js(__('site.toast.locale', ['language' => __('site.locales.'.$code)])))"
                        @class([
                            'rounded-lg px-2.5 py-1 text-xs font-bold uppercase',
                            'bg-accent text-white' => app()->getLocale() === $code,
                            'text-muted hover:text-ink' => app()->getLocale() !== $code,
                        ])
                    >
                        {{ $code }}
                    </a>
                @endforeach
            </div>

            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="btn btn-primary hidden px-4 py-2.5 text-sm md:inline-flex" wire:navigate>
                {{ __('site.nav.contact') }}
            </a>

            <button
                type="button"
                class="grid size-10 place-items-center rounded-xl border border-line bg-elevated/80 lg:hidden"
                @click="$store.ui.menu = ! $store.ui.menu; $store.toast.push($store.ui.menu ? @js(__('site.toast.menu_open')) : @js(__('site.toast.menu_close')), 'info')"
                :aria-label="$store.ui.menu ? '{{ __('site.nav.close') }}' : '{{ __('site.nav.menu') }}'"
            >
                <span x-show="! $store.ui.menu"><x-icon name="menu" class="size-5" /></span>
                <span x-cloak x-show="$store.ui.menu"><x-icon name="close" class="size-5" /></span>
            </button>
        </div>
    </div>

    <div x-cloak x-show="$store.ui.menu" x-transition class="border-t border-line bg-canvas lg:hidden">
        <nav class="mx-auto flex max-w-6xl flex-col gap-1 px-5 py-4">
            @foreach ($links as $link)
                <a
                    href="{{ route($link['route'], ['locale' => app()->getLocale()]) }}"
                    wire:navigate
                    @click="$store.ui.menu = false"
                    class="rounded-xl px-3 py-3 text-base font-semibold {{ request()->routeIs($link['route']) || ($link['route'] === 'contact' && request()->routeIs('contact.sent')) ? 'bg-elevated' : '' }}"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
            <div class="mt-2 flex gap-2">
                @foreach (['en', 'de', 'fr'] as $code)
                    <a
                        href="{{ route(request()->route()->getName(), array_merge(request()->route()->parameters(), ['locale' => $code])) }}"
                        wire:navigate
                        @click="$store.toast.hold(@js(__('site.toast.locale', ['language' => __('site.locales.'.$code)])))"
                        class="rounded-xl border border-line px-3 py-2 text-xs font-bold uppercase {{ app()->getLocale() === $code ? 'bg-accent text-white' : '' }}"
                    >
                        {{ __('site.locales.'.$code) }}
                    </a>
                @endforeach
            </div>
        </nav>
    </div>
</header>

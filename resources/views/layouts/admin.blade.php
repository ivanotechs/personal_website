<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" data-accent="{{ $settings->accent ?? '#2f7cff' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? ($settings->site_name ?? 'Ivanotechs') }}</title>
        <x-seo :title="$title ?? null" :description="$description ?? null" :index="false" />
        @fonts
        @include('partials.theme-boot')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen font-sans antialiased">
        @auth
            <div class="lg:grid lg:grid-cols-[17rem_1fr]">
                <aside class="no-print border-b border-line bg-elevated/70 lg:sticky lg:top-0 lg:h-screen lg:overflow-y-auto lg:border-b-0 lg:border-r">
                    <div class="flex items-center justify-between px-5 py-5">
                        <x-site.logo />
                    </div>
                    <nav class="flex gap-2 overflow-x-auto px-4 pb-4 lg:flex-col lg:overflow-visible lg:px-3">
                        @foreach ([
                            'admin.dashboard' => __('site.admin.nav.dashboard'),
                            'admin.profile' => __('site.admin.nav.profile'),
                            'admin.account' => __('site.admin.nav.account'),
                            'admin.branding' => __('site.admin.nav.branding'),
                            'admin.themes' => __('site.admin.nav.themes'),
                            'admin.experience' => __('site.admin.nav.experience'),
                            'admin.education' => __('site.admin.nav.education'),
                            'admin.skills' => __('site.admin.nav.skills'),
                            'admin.projects.index' => __('site.admin.nav.projects'),
                            'admin.messages' => __('site.admin.nav.messages'),
                        ] as $route => $label)
                            <a
                                href="{{ route($route, ['locale' => app()->getLocale()]) }}"
                                wire:navigate
                                @class([
                                    'whitespace-nowrap rounded-xl px-3 py-2.5 text-sm font-semibold',
                                    'bg-accent text-white' => request()->routeIs($route) || ($route === 'admin.projects.index' && request()->routeIs('admin.projects.*')),
                                    'text-muted hover:bg-canvas hover:text-ink' => ! (request()->routeIs($route) || ($route === 'admin.projects.index' && request()->routeIs('admin.projects.*'))),
                                ])
                            >
                                {{ $label }}
                            </a>
                        @endforeach
                    </nav>
                    <form method="POST" action="{{ route('admin.logout', ['locale' => app()->getLocale()]) }}" class="px-4 pb-5">
                        @csrf
                        <button type="submit" class="w-full rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-muted hover:bg-canvas hover:text-ink">
                            {{ __('site.admin.nav.logout') }}
                        </button>
                    </form>
                </aside>

                <div class="min-w-0">
                    <header class="no-print flex items-center justify-between gap-3 border-b border-line px-5 py-4">
                        <p class="text-sm font-semibold text-muted">{{ __('site.admin.preview') }}</p>
                        <div class="flex items-center gap-2">
                            <div class="flex rounded-xl border border-line bg-elevated p-1">
                                @foreach (['en', 'de', 'fr'] as $code)
                                    <a
                                        href="{{ route(request()->route()->getName(), array_merge(request()->route()->parameters(), ['locale' => $code])) }}"
                                        wire:navigate
                                        @class([
                                            'rounded-lg px-2 py-1 text-xs font-bold uppercase',
                                            'bg-accent text-white' => app()->getLocale() === $code,
                                            'text-muted' => app()->getLocale() !== $code,
                                        ])
                                    >{{ $code }}</a>
                                @endforeach
                            </div>
                            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="btn btn-ghost px-3 py-2 text-sm" wire:navigate>
                                {{ __('site.admin.nav.view_site') }}
                            </a>
                        </div>
                    </header>
                    <div class="px-5 py-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        @else
            <main class="mx-auto max-w-md px-5 py-16">
                {{ $slot }}
            </main>
        @endauth
        @include('partials.theme-scripts')
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" data-accent="{{ $settings->accent ?? '#2f7cff' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? ($settings->site_name ?? 'Ivanotechs') }}</title>
        <x-seo :title="$title ?? null" :description="$description ?? null" :index="true" />
        @fonts
        @include('partials.theme-boot')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen font-sans antialiased">
        <x-site.header />
        <main>
            {{ $slot }}
        </main>
        <x-site.footer />
        <x-toaster />
        @include('partials.theme-scripts')
    </body>
</html>

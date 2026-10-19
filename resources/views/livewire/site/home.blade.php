<div>
    <section class="mx-auto grid max-w-6xl items-center gap-10 px-5 py-14 lg:grid-cols-[1.1fr_0.9fr] lg:py-20">
        <div>
            <p class="kicker">{{ $settings?->handle }}</p>
            <h1 class="mt-4 max-w-xl text-4xl font-extrabold tracking-tight text-balance sm:text-6xl">{{ $settings?->full_name }}</h1>
            <p class="mt-3 text-lg font-semibold text-accent">{{ $settings?->text('role_label') }}</p>
            <p class="mt-5 max-w-xl text-lg leading-8 text-muted">{{ $settings?->text('tagline') }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('projects', ['locale' => app()->getLocale()]) }}" class="btn btn-primary" wire:navigate>{{ __('site.hero.primary') }}</a>
                <a href="{{ route('cv', ['locale' => app()->getLocale()]) }}" class="btn btn-ghost" wire:navigate>{{ __('site.hero.secondary') }}</a>
            </div>
        </div>
        <div class="surface overflow-hidden p-3">
            @if ($settings?->portraitUrl())
                <img src="{{ $settings->portraitUrl() }}" alt="{{ $settings->full_name }}" class="aspect-[4/5] w-full rounded-[1.4rem] object-cover">
            @else
                <x-site.hero-art />
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-16">
        <div class="max-w-2xl">
            <p class="kicker">{{ __('site.home.services_kicker') }}</p>
            <h2 class="mt-3 text-3xl font-extrabold tracking-tight">{{ __('site.home.services_title') }}</h2>
            <p class="mt-3 text-muted">{{ $settings?->text('availability') }}</p>
        </div>
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($settings?->highlights ?? [] as $item)
                <article class="surface p-5">
                    <span class="grid size-12 place-items-center rounded-2xl bg-accent/15 text-accent">
                        <x-icon :name="$item['icon'] ?? 'spark'" class="size-6" />
                    </span>
                    <h3 class="mt-4 text-lg font-bold">{{ $item['title'][app()->getLocale()] ?? ($item['title']['en'] ?? '') }}</h3>
                    <p class="mt-2 text-sm leading-6 text-muted">{{ $item['body'][app()->getLocale()] ?? ($item['body']['en'] ?? '') }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-16">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <p class="kicker">{{ __('site.home.work_kicker') }}</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight">{{ __('site.home.work_title') }}</h2>
                <p class="mt-3 text-muted">{{ __('site.home.work_lead') }}</p>
            </div>
            <a href="{{ route('projects', ['locale' => app()->getLocale()]) }}" class="btn btn-ghost" wire:navigate>{{ __('site.home.work_all') }}</a>
        </div>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @foreach ($projects as $project)
                <x-site.project-card :project="$project" />
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-16">
        <div class="surface grid gap-8 p-6 md:grid-cols-[1.2fr_0.8fr] md:p-10">
            <div>
                <p class="kicker">{{ __('site.home.about_kicker') }}</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight">{{ __('site.home.about_title') }}</h2>
                <p class="mt-4 leading-7 text-muted">{{ $settings?->text('about_short') }}</p>
                <a href="{{ route('about', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mt-6" wire:navigate>{{ __('site.home.about_more') }}</a>
            </div>
            <div class="grid content-center gap-3">
                <div class="rounded-2xl border border-line bg-canvas/60 p-4">
                    <p class="text-2xl font-extrabold">{{ collect($settings?->spoken_languages ?? [])->count() }}</p>
                    <p class="text-sm text-muted">{{ __('site.cv.languages') }}</p>
                </div>
                <div class="rounded-2xl border border-line bg-canvas/60 p-4">
                    <p class="text-lg font-extrabold">{{ $settings?->city }}</p>
                    <p class="text-sm text-muted">{{ $settings?->country }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-20">
        <div class="overflow-hidden rounded-[2rem] bg-accent px-6 py-10 text-white md:px-10">
            <h2 class="max-w-xl text-3xl font-extrabold tracking-tight">{{ __('site.home.cta_title') }}</h2>
            <p class="mt-3 max-w-xl text-white/80">{{ $settings?->text('availability') }}</p>
            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="btn mt-6 bg-white text-accent" wire:navigate>{{ __('site.home.cta_button') }}</a>
        </div>
    </section>
</div>

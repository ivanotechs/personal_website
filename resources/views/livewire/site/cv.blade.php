<div>
    <section class="mx-auto flex max-w-6xl flex-wrap items-end justify-between gap-6 px-5 py-14">
        <div class="max-w-2xl">
            <p class="kicker">{{ __('site.cv.kicker') }}</p>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ $settings?->full_name }}</h1>
            <p class="mt-4 text-lg leading-8 text-muted">{{ $settings?->text('role_label') }}</p>
        </div>
        <button type="button" class="btn btn-primary no-print" onclick="window.print()">{{ __('site.cv.print') }}</button>
    </section>

    <section class="mx-auto grid max-w-6xl gap-4 px-5 pb-12 lg:grid-cols-[0.85fr_1.15fr]">
        <article class="surface p-6">
            @if ($settings?->portraitUrl())
                <img src="{{ $settings->portraitUrl() }}" alt="" class="mb-4 aspect-square w-36 rounded-2xl object-cover">
            @endif
            <h2 class="text-2xl font-extrabold">{{ $settings?->text('role_label') }}</h2>
            <p class="mt-3 text-sm leading-6 text-muted">{{ $settings?->text('about_short') }}</p>
            <dl class="mt-5 space-y-2 text-sm">
                <div><dt class="font-semibold">{{ $settings?->public_email }}</dt></div>
                <div><dt>{{ $settings?->phone }}</dt></div>
                <div><dt>{{ $settings?->address }}, {{ $settings?->city }}, {{ $settings?->country }}</dt></div>
                <div><dt>{{ $settings?->text('nationality') }}</dt></div>
            </dl>
        </article>
        <div class="space-y-4">
            @foreach ($experiences as $item)
                <article class="surface relative p-6 pl-8">
                    <span class="absolute top-8 bottom-8 left-4 w-px bg-accent/40"></span>
                    <span class="absolute top-8 left-3 size-2.5 rounded-full bg-accent"></span>
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-muted">
                        {{ $item->start_date?->format('m.Y') }}
                        —
                        {{ $item->is_current ? __('site.cv.current') : $item->end_date?->format('m.Y') }}
                    </p>
                    <h2 class="mt-2 text-xl font-extrabold">{{ $item->text('role') }}</h2>
                    <p class="text-sm font-semibold text-accent">{{ $item->company }}@if ($item->location) · {{ $item->location }}@endif</p>
                    <p class="mt-2 leading-7 text-muted">{{ $item->text('summary') }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-12">
        <h2 class="text-2xl font-extrabold">{{ __('site.cv.education') }}</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-3">
            @foreach ($educations as $item)
                <article class="surface p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-muted">
                        {{ $item->start_date?->format('m.Y') }}
                        —
                        {{ $item->is_current ? __('site.cv.current') : $item->end_date?->format('m.Y') }}
                    </p>
                    <h3 class="mt-2 font-bold">{{ $item->text('title') }}</h3>
                    @if ($item->school)
                        <p class="mt-1 text-sm font-semibold text-accent">{{ $item->school }}</p>
                    @endif
                    <p class="mt-2 text-sm leading-6 text-muted">{{ $item->text('summary') }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-12">
        <h2 class="text-2xl font-extrabold">{{ __('site.cv.skills') }}</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-3">
            @foreach ($skills as $group => $items)
                <article class="surface p-5">
                    <h3 class="font-bold">{{ $group }}</h3>
                    <p class="mt-2 text-sm leading-6 text-muted">{{ $items->pluck('name')->implode(', ') }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-20">
        <article class="surface p-6">
            <h2 class="text-2xl font-extrabold">{{ __('site.cv.languages') }}</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($settings?->spoken_languages ?? [] as $language)
                    <span class="rounded-full border border-line px-3 py-1 text-sm font-semibold">
                        {{ $language['name'][app()->getLocale()] ?? ($language['name']['en'] ?? '') }}
                        · {{ $language['level'][app()->getLocale()] ?? ($language['level']['en'] ?? '') }}
                    </span>
                @endforeach
            </div>
        </article>
    </section>
</div>

<div>
    <section class="mx-auto grid max-w-6xl items-center gap-8 px-5 py-14 lg:grid-cols-[1.2fr_0.8fr]">
        <div>
            <p class="kicker">{{ __('site.about.kicker') }}</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-extrabold tracking-tight sm:text-5xl">{{ $settings?->full_name }}</h1>
            <p class="mt-5 max-w-2xl text-lg leading-8 text-muted">{{ $settings?->text('about_long') }}</p>
        </div>
        @if ($settings?->portraitUrl())
            <img src="{{ $settings->portraitUrl() }}" alt="{{ $settings->full_name }}" class="aspect-[4/5] w-full max-w-sm justify-self-end rounded-[2rem] object-cover">
        @endif
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-12">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($settings?->highlights ?? [] as $item)
                <article class="surface p-5">
                    <span class="grid size-11 place-items-center rounded-2xl bg-accent text-white">
                        <x-icon :name="$item['icon'] ?? 'spark'" class="size-5" />
                    </span>
                    <h2 class="mt-4 font-bold">{{ $item['title'][app()->getLocale()] ?? ($item['title']['en'] ?? '') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-muted">{{ $item['body'][app()->getLocale()] ?? ($item['body']['en'] ?? '') }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-20">
        <article class="surface p-6 md:p-10">
            <p class="kicker">{{ __('site.contact.kicker') }}</p>
            <h2 class="mt-3 text-3xl font-extrabold tracking-tight">{{ $settings?->text('availability') }}</h2>
            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mt-8" wire:navigate>{{ __('site.about.cta_button') }}</a>
        </article>
    </section>
</div>

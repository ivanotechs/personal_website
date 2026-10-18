<div>
    <div x-data="{ filter: 'all' }">
    <section class="mx-auto max-w-6xl px-5 py-14">
        <p class="kicker">{{ __('site.projects.kicker') }}</p>
        <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl">{{ __('site.projects.title') }}</h1>
        <p class="mt-4 max-w-2xl text-lg leading-8 text-muted">{{ __('site.projects.lead') }}</p>
        <div class="mt-6 flex flex-wrap gap-2" role="group" aria-label="{{ __('site.projects.kicker') }}">
            <button type="button" class="rounded-full border px-4 py-2 text-sm font-bold" :class="filter === 'all' ? 'border-transparent bg-accent text-white' : 'border-line text-muted'" @click="filter = 'all'">{{ __('site.projects.filters.all') }}</button>
            @foreach ($categories as $filter)
                <button type="button" class="rounded-full border px-4 py-2 text-sm font-bold" :class="filter === '{{ $filter }}' ? 'border-transparent bg-accent text-white' : 'border-line text-muted'" @click="filter = '{{ $filter }}'">
                    {{ __('site.projects.filters.'.$filter) }}
                </button>
            @endforeach
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-4 px-5 pb-20 md:grid-cols-2">
        @foreach ($projects as $project)
            <div x-show="filter === 'all' || filter === '{{ $project->category }}'" x-cloak>
                <x-site.project-card :project="$project" />
            </div>
        @endforeach
    </section>
    </div>
</div>

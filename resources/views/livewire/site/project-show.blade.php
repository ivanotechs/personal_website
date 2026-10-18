<div>
    <section class="mx-auto max-w-6xl px-5 py-14">
        <a href="{{ route('projects', ['locale' => app()->getLocale()]) }}" class="text-sm font-bold text-accent" wire:navigate>← {{ __('site.projects.back') }}</a>
        <p class="kicker mt-6">{{ __('site.projects.filters.'.$project->category) }} · {{ $project->year }}</p>
        <h1 class="mt-3 max-w-3xl text-4xl font-extrabold tracking-tight sm:text-5xl">{{ $project->text('title') }}</h1>
        <p class="mt-4 max-w-2xl text-lg leading-8 text-muted">{{ $project->text('summary') }}</p>
        <div class="mt-8 grid gap-8 lg:grid-cols-[1.4fr_0.6fr]">
            <div class="space-y-4 text-lg leading-8">
                @foreach (preg_split("/\n\s*\n/", $project->text('body')) as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
            <aside class="surface h-fit space-y-4 p-5">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-[0.14em] text-muted">{{ __('site.projects.stack') }}</h2>
                    <ul class="mt-3 flex flex-wrap gap-2">
                        @foreach ($project->stack ?? [] as $item)
                            <li class="rounded-full bg-accent/10 px-3 py-1 text-sm font-semibold text-accent">{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @if ($project->url)
                    <a class="btn btn-primary w-full" href="{{ $project->url }}" rel="noopener">{{ parse_url($project->url, PHP_URL_HOST) ?: $project->url }}</a>
                @endif
                @if ($project->github_url)
                    <a class="btn btn-ghost w-full" href="{{ $project->github_url }}" rel="noopener">GitHub</a>
                @endif
            </aside>
        </div>
        <div class="mt-10 flex flex-wrap justify-between gap-3 border-t border-line pt-6">
            @if ($neighbors['previous'])
                <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $neighbors['previous']->slug]) }}" class="btn btn-ghost" wire:navigate>
                    ← {{ $neighbors['previous']->text('title') }}
                </a>
            @else
                <span></span>
            @endif
            @if ($neighbors['next'])
                <a href="{{ route('projects.show', ['locale' => app()->getLocale(), 'project' => $neighbors['next']->slug]) }}" class="btn btn-primary" wire:navigate>
                    {{ $neighbors['next']->text('title') }} →
                </a>
            @endif
        </div>
    </section>
</div>

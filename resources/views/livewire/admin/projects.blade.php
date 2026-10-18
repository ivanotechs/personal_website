<div class="mx-auto max-w-5xl">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">{{ __('site.admin.projects.title') }}</h1>
            <p class="mt-2 text-muted">{{ __('site.admin.projects.lead') }}</p>
        </div>
        <a href="{{ route('admin.projects.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary" wire:navigate>{{ __('site.admin.projects.new') }}</a>
    </div>
    <div class="surface mt-6 overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-line text-xs uppercase tracking-[0.14em] text-muted">
                <tr>
                    <th class="px-4 py-3 font-bold">{{ __('site.admin.form.title') }}</th>
                    <th class="px-4 py-3 font-bold">{{ __('site.admin.form.category') }}</th>
                    <th class="px-4 py-3 font-bold">{{ __('site.admin.form.year') }}</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr class="border-b border-line last:border-0">
                        <td class="px-4 py-4 font-semibold">{{ __('site.projects.items.'.$project['slug'].'.title') }}</td>
                        <td class="px-4 py-4 text-muted">{{ __('site.projects.filters.'.$project['category']) }}</td>
                        <td class="px-4 py-4 text-muted">{{ $project['year'] }}</td>
                        <td class="px-4 py-4 text-right">
                            <a href="{{ route('admin.projects.edit', ['locale' => app()->getLocale(), 'project' => $project['slug']]) }}" class="font-bold text-accent" wire:navigate>{{ __('site.admin.projects.edit') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

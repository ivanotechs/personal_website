<div>
    <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.dashboard') }}</h1>
    <p class="mt-2 text-muted">{{ $settings?->full_name }} · {{ $settings?->public_email }}</p>
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ([
            'projects' => route('admin.projects.index', ['locale' => app()->getLocale()]),
            'experience' => route('admin.experience', ['locale' => app()->getLocale()]),
            'education' => route('admin.education', ['locale' => app()->getLocale()]),
            'skills' => route('admin.skills', ['locale' => app()->getLocale()]),
            'messages' => route('admin.messages', ['locale' => app()->getLocale()]),
        ] as $key => $href)
            <a href="{{ $href }}" class="surface p-5" wire:navigate>
                <p class="text-3xl font-extrabold">{{ $counts[$key] }}</p>
                <p class="mt-1 font-semibold">{{ __('site.admin.nav.'.$key) }}</p>
                @if ($key === 'messages')
                    <p class="mt-1 text-sm text-muted">{{ $counts['unread'] }}</p>
                @endif
            </a>
        @endforeach
    </div>
</div>

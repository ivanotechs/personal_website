<div>
    <section class="mx-auto grid max-w-6xl gap-8 px-5 py-14 lg:grid-cols-[0.8fr_1.2fr]">
        <div>
            <p class="kicker">{{ __('site.contact.kicker') }}</p>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight">{{ __('site.contact.title') }}</h1>
            <p class="mt-4 leading-7 text-muted">{{ __('site.contact.lead') }}</p>
            <div class="surface mt-8 space-y-2 p-5 text-sm leading-6">
                <p class="font-bold">{{ $settings?->full_name }}</p>
                <p class="text-muted">{{ $settings?->text('availability') }}</p>
                <p><a class="font-semibold text-accent" href="mailto:{{ $settings?->public_email }}">{{ $settings?->public_email }}</a></p>
                <p>{{ $settings?->phone }}</p>
                <p>{{ $settings?->address }}</p>
                <p>{{ $settings?->city }}, {{ $settings?->country }}</p>
                <div class="flex flex-wrap gap-3 pt-2">
                    @if ($settings?->github_url)<a class="font-semibold text-accent" href="{{ $settings->github_url }}" rel="me">GitHub</a>@endif
                    @if ($settings?->linkedin_url)<a class="font-semibold text-accent" href="{{ $settings->linkedin_url }}" rel="me">LinkedIn</a>@endif
                    @if ($settings?->xing_url)<a class="font-semibold text-accent" href="{{ $settings->xing_url }}" rel="me">Xing</a>@endif
                    @if ($settings?->website_url)<a class="font-semibold text-accent" href="{{ $settings->website_url }}">{{ parse_url($settings->website_url, PHP_URL_HOST) }}</a>@endif
                </div>
            </div>
        </div>

        <div class="surface p-5 md:p-7">
            <form wire:submit="submit" class="grid gap-4">
                    <label class="grid gap-2 text-sm font-semibold">
                        {{ __('site.contact.name') }}
                        <input class="field" type="text" wire:model="name" autocomplete="name">
                        @error('name') <span class="text-sm font-medium text-red-500">{{ $message }}</span> @enderror
                    </label>
                    <label class="grid gap-2 text-sm font-semibold">
                        {{ __('site.contact.email') }}
                        <input class="field" type="email" wire:model="email" autocomplete="email">
                        @error('email') <span class="text-sm font-medium text-red-500">{{ $message }}</span> @enderror
                    </label>
                    <label class="grid gap-2 text-sm font-semibold">
                        {{ __('site.contact.subject') }}
                        <input class="field" type="text" wire:model="subject">
                        @error('subject') <span class="text-sm font-medium text-red-500">{{ $message }}</span> @enderror
                    </label>
                    <label class="grid gap-2 text-sm font-semibold">
                        {{ __('site.contact.message') }}
                        <textarea class="field min-h-36" wire:model="message"></textarea>
                        @error('message') <span class="text-sm font-medium text-red-500">{{ $message }}</span> @enderror
                    </label>
                    <x-action-button type="submit" class="btn-primary" target="submit">{{ __('site.contact.send') }}</x-action-button>
            </form>
        </div>
    </section>
</div>

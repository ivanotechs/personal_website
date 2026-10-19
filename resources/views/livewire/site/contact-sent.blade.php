<div>
    <section class="mx-auto flex min-h-[60vh] max-w-xl flex-col justify-center px-5 py-20">
        <p class="kicker">{{ __('site.contact.kicker') }}</p>
        <h1 class="mt-4 text-4xl font-extrabold tracking-tight">{{ __('site.contact.sent_title') }}</h1>
        <p class="mt-4 text-lg leading-8 text-muted">{{ __('site.contact.sent_body') }}</p>
        <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mt-8 w-fit" wire:navigate>{{ __('site.contact.another') }}</a>
    </section>
</div>

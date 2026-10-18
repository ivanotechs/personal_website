<div>
    <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.themes') }}</h1>
    <p class="mt-2 text-sm text-muted">The chosen colour is stored for the site.</p>
    <div class="mt-6 flex flex-wrap gap-3">
        @foreach (['#2f7cff', '#7c5cff', '#14b8c4', '#1f9d6a'] as $accent)
            <button type="button" class="relative size-12 rounded-2xl ring-2 ring-transparent ring-offset-2 ring-offset-canvas" style="background: {{ $accent }}" wire:click="save('{{ $accent }}')" wire:loading.attr="disabled" wire:target="save">
                <span wire:loading wire:target="save" class="absolute inset-2 animate-spin rounded-full border-2 border-white border-r-transparent"></span>
            </button>
        @endforeach
    </div>
</div>

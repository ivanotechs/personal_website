<div class="mx-auto max-w-xl">
    <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.branding') }}</h1>
    @if ($saved)
        <p class="mt-3 rounded-xl bg-accent/10 px-4 py-3 text-sm font-semibold text-accent">{{ __('site.admin.saved') }}</p>
    @endif
    <form wire:submit="save" class="surface mt-6 grid gap-4 p-5">
        @if ($settings?->logoUrl())
            <img src="{{ $settings->logoUrl() }}" alt="" class="size-16 rounded-2xl object-cover">
        @endif
        <label class="grid gap-2 text-sm font-semibold">Site name<input class="field" wire:model="site_name"></label>
        <label class="grid gap-2 text-sm font-semibold">Accent<input class="field h-12" type="color" wire:model="accent"></label>
        <label class="grid gap-2 text-sm font-semibold">Logo<input class="field" type="file" wire:model="logo" accept="image/*"></label>
        @error('logo') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        <x-action-button type="submit" class="btn-primary w-fit" target="save">{{ __('site.admin.save') }}</x-action-button>
    </form>
</div>

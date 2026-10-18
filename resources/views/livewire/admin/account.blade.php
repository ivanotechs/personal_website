<div class="mx-auto max-w-xl">
    <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.account') }}</h1>
    <p class="mt-2 text-sm text-muted">This email and password sign you into the admin. Public contact details live on the profile page.</p>
    @if ($saved)
        <p class="mt-3 rounded-xl bg-accent/10 px-4 py-3 text-sm font-semibold text-accent">{{ __('site.admin.saved') }}</p>
    @endif
    <form wire:submit="save" class="surface mt-6 grid gap-4 p-5">
        <label class="grid gap-2 text-sm font-semibold">Name<input class="field" wire:model="name"></label>
        <label class="grid gap-2 text-sm font-semibold">Login email<input class="field" type="email" wire:model="email"></label>
        @error('email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        <label class="grid gap-2 text-sm font-semibold">Phone<input class="field" wire:model="phone"></label>
        <label class="grid gap-2 text-sm font-semibold">Address<input class="field" wire:model="address"></label>
        <label class="grid gap-2 text-sm font-semibold">City<input class="field" wire:model="city"></label>
        <label class="grid gap-2 text-sm font-semibold">Country<input class="field" wire:model="country"></label>
        <label class="grid gap-2 text-sm font-semibold">New password<input class="field" type="password" wire:model="password" autocomplete="new-password"></label>
        <label class="grid gap-2 text-sm font-semibold">Confirm password<input class="field" type="password" wire:model="password_confirmation" autocomplete="new-password"></label>
        @error('password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        <x-action-button type="submit" class="btn-primary w-fit" target="save">{{ __('site.admin.save') }}</x-action-button>
    </form>
</div>

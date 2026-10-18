<div class="surface p-6">
    <h1 class="text-2xl font-extrabold">{{ __('site.admin.login.title') }}</h1>
    <form wire:submit="submit" class="mt-6 grid gap-4">
        <label class="grid gap-2 text-sm font-semibold">
            {{ __('site.admin.login.email') }}
            <input class="field" type="email" wire:model="email" autocomplete="username">
            @error('email') <span class="text-sm font-medium text-red-500">{{ $message }}</span> @enderror
        </label>
        <label class="grid gap-2 text-sm font-semibold">
            {{ __('site.admin.login.password') }}
            <input class="field" type="password" wire:model="password" autocomplete="current-password">
        </label>
        <label class="flex items-center gap-2 text-sm font-semibold">
            <input type="checkbox" wire:model="remember" class="size-4 accent-[var(--accent)]">
            {{ __('site.admin.login.remember') }}
        </label>
        <x-action-button type="submit" class="btn-primary" target="submit">{{ __('site.admin.login.submit') }}</x-action-button>
    </form>
</div>

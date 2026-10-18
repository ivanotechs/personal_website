<div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
    <div>
        <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.experience') }}</h1>
        <div class="mt-4 grid gap-2">
            @foreach ($items as $item)
                <button type="button" class="surface px-4 py-3 text-left" wire:click="edit({{ $item->id }})">
                    <span class="block font-bold">{{ $item->company }}</span>
                    <span class="text-sm text-muted">{{ $item->text('role') }}</span>
                </button>
            @endforeach
        </div>
    </div>
    <form wire:submit="save" class="surface grid gap-4 p-5">
        <label class="grid gap-2 text-sm font-semibold">Company<input class="field" wire:model="company"></label>
        <label class="grid gap-2 text-sm font-semibold">Location<input class="field" wire:model="location"></label>
        <div class="grid gap-4 md:grid-cols-2">
            <label class="grid gap-2 text-sm font-semibold">Start<input class="field" type="date" wire:model="start_date"></label>
            <label class="grid gap-2 text-sm font-semibold">End<input class="field" type="date" wire:model="end_date"></label>
        </div>
        <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" wire:model="is_current"> {{ __('site.cv.current') }}</label>
        <label class="grid gap-2 text-sm font-semibold">Sort<input class="field" type="number" wire:model="sort"></label>
        <x-admin.locales label="Role" model="role" />
        <x-admin.locales label="Summary" model="summary" :area="true" />
        @error('role.en') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        <div class="flex gap-3">
            <button type="submit" class="btn btn-primary">{{ __('site.admin.save') }}</button>
            <button type="button" class="btn btn-ghost" wire:click="createNew">New</button>
            @if ($editing)
                <button type="button" class="btn btn-ghost text-red-500" wire:click="delete({{ $editing }})">Delete</button>
            @endif
        </div>
    </form>
</div>

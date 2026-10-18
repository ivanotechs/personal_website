<div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
    <div>
        <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.skills') }}</h1>
        <div class="mt-4 grid gap-2">
            @foreach ($items as $item)
                <button type="button" class="surface px-4 py-3 text-left" wire:click="edit({{ $item->id }})">
                    <span class="block font-bold">{{ $item->name }}</span>
                    <span class="text-sm text-muted">{{ $item->text('group_label') }}</span>
                </button>
            @endforeach
        </div>
    </div>
    <form wire:submit="save" class="surface grid gap-4 p-5">
        <label class="grid gap-2 text-sm font-semibold">Name<input class="field" wire:model="name"></label>
        <label class="grid gap-2 text-sm font-semibold">Sort<input class="field" type="number" wire:model="sort"></label>
        <x-admin.locales label="Group" model="group_label" />
        <div class="flex gap-3">
            <button type="submit" class="btn btn-primary">{{ __('site.admin.save') }}</button>
            <button type="button" class="btn btn-ghost" wire:click="createNew">New</button>
            @if ($editing)
                <button type="button" class="btn btn-ghost text-red-500" wire:click="delete({{ $editing }})">Delete</button>
            @endif
        </div>
    </form>
</div>

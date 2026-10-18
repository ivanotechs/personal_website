<div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
    <div>
        <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.skills') }}</h1>
        <div class="mt-4 grid gap-2">
            @foreach ($items as $item)
                <x-action-button class="surface w-full justify-start px-4 py-3 text-left" wire:click="edit({{ $item->id }})" target="edit">
                    <span class="block font-bold">{{ $item->name }}</span>
                    <span class="text-sm text-muted">{{ $item->text('group_label') }}</span>
                </x-action-button>
            @endforeach
        </div>
    </div>
    <form wire:submit="save" class="surface grid gap-4 p-5">
        <label class="grid gap-2 text-sm font-semibold">Name<input class="field" wire:model="name"></label>
        <label class="grid gap-2 text-sm font-semibold">Sort<input class="field" type="number" wire:model="sort"></label>
        <x-admin.locales label="Group" model="group_label" />
        <div class="flex gap-3">
            <x-action-button type="submit" class="btn-primary" target="save">{{ __('site.admin.save') }}</x-action-button>
            <x-action-button class="btn-ghost" wire:click="createNew" target="createNew">New</x-action-button>
            @if ($editing)
                <x-action-button class="btn-ghost text-red-500" wire:click="delete({{ $editing }})" target="delete">Delete</x-action-button>
            @endif
        </div>
    </form>
</div>

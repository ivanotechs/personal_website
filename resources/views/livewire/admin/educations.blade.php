<div class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr]">
    <div>
        <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.education') }}</h1>
        <div class="mt-4 grid gap-2">
            @foreach ($items as $item)
                <x-action-button class="surface w-full justify-start px-4 py-3 text-left" wire:click="edit({{ $item->id }})" target="edit">
                    <span class="block font-bold">{{ $item->text('title') }}</span>
                    <span class="text-sm text-muted">{{ $item->school }}</span>
                </x-action-button>
            @endforeach
        </div>
    </div>
    <form wire:submit="save" class="surface grid gap-4 p-5">
        <label class="grid gap-2 text-sm font-semibold">School<input class="field" wire:model="school"></label>
        <label class="grid gap-2 text-sm font-semibold">Location<input class="field" wire:model="location"></label>
        <div class="grid gap-4 md:grid-cols-2">
            <label class="grid gap-2 text-sm font-semibold">Start<input class="field" type="date" wire:model="start_date"></label>
            <label class="grid gap-2 text-sm font-semibold">End<input class="field" type="date" wire:model="end_date"></label>
        </div>
        <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" wire:model="is_current"> {{ __('site.cv.current') }}</label>
        <label class="grid gap-2 text-sm font-semibold">Sort<input class="field" type="number" wire:model="sort"></label>
        <x-admin.locales label="Title" model="title" />
        <x-admin.locales label="Summary" model="summary" :area="true" />
        <div class="flex gap-3">
            <x-action-button type="submit" class="btn-primary" target="save">{{ __('site.admin.save') }}</x-action-button>
            <x-action-button class="btn-ghost" wire:click="createNew" target="createNew">New</x-action-button>
            @if ($editing)
                <x-action-button class="btn-ghost text-red-500" wire:click="delete({{ $editing }})" target="delete">Delete</x-action-button>
            @endif
        </div>
    </form>
</div>

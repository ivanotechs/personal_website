<div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
    <div>
        <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.messages') }}</h1>
        <div class="mt-4 grid gap-2">
            @forelse ($items as $item)
                <button type="button" class="surface px-4 py-3 text-left" wire:click="show({{ $item->id }})">
                    <span class="block font-bold">{{ $item->name }}</span>
                    <span class="text-sm text-muted">{{ $item->subject }}</span>
                </button>
            @empty
                <p class="text-sm text-muted">No messages yet.</p>
            @endforelse
        </div>
    </div>
    @if ($current)
        <article class="surface p-5">
            <p class="text-sm font-semibold text-accent">{{ $current->email }}</p>
            <h2 class="mt-2 text-2xl font-extrabold">{{ $current->subject }}</h2>
            <p class="mt-4 whitespace-pre-line leading-7">{{ $current->body }}</p>
            <button type="button" class="btn btn-ghost mt-6 text-red-500" wire:click="remove({{ $current->id }})">Delete</button>
        </article>
    @endif
</div>

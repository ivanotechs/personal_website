@props(['target' => null, 'notice' => null])

<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'btn']) }}
    @if ($target) wire:loading.attr="disabled" wire:target="{{ $target }}" @endif
    @if ($notice) x-data="{ busy: false }" x-on:click="busy = true; $store.toast.push(@js($notice)); setTimeout(() => busy = false, 700)" @endif
>
    @if ($target)
        <span wire:loading wire:target="{{ $target }}" class="size-4 shrink-0 animate-spin rounded-full border-2 border-current border-r-transparent"></span>
    @endif
    @if ($notice)
        <span x-cloak x-show="busy" class="size-4 shrink-0 animate-spin rounded-full border-2 border-current border-r-transparent"></span>
    @endif
    <span class="min-w-0">{{ $slot }}</span>
</button>

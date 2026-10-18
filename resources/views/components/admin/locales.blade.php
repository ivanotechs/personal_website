@props(['label', 'model', 'area' => false])

<div class="grid gap-3 md:grid-cols-3">
    @foreach (['en', 'de', 'fr'] as $code)
        <label class="grid gap-2 text-sm font-semibold">
            {{ $label }} ({{ strtoupper($code) }})
            @if ($area)
                <textarea class="field min-h-28" wire:model="{{ $model }}.{{ $code }}"></textarea>
            @else
                <input class="field" type="text" wire:model="{{ $model }}.{{ $code }}">
            @endif
        </label>
    @endforeach
</div>

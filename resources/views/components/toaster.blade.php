<div
    x-data
    class="pointer-events-none fixed inset-x-0 top-24 z-[200] flex flex-col items-end gap-2 px-4 sm:px-6"
    style="z-index: 200"
    aria-live="polite"
    aria-relevant="additions"
>
    <template x-for="item in $store.toast.items" :key="item.id">
        <div
            class="pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-2xl border bg-elevated px-4 py-3 text-sm font-semibold shadow-2xl"
            :class="{
                'border-emerald-400/40 text-emerald-100': item.type === 'success',
                'border-red-400/40 text-red-100': item.type === 'error',
                'border-line text-ink': item.type !== 'success' && item.type !== 'error',
            }"
        >
            <span class="mt-0.5 size-2 shrink-0 rounded-full" :class="{
                'bg-emerald-300': item.type === 'success',
                'bg-red-300': item.type === 'error',
                'bg-accent': item.type !== 'success' && item.type !== 'error',
            }"></span>
            <p class="flex-1 leading-5" x-text="item.message"></p>
            <button type="button" class="text-current/70" @click="$store.toast.dismiss(item.id)" aria-label="{{ __('site.toast.dismiss') }}">×</button>
        </div>
    </template>
</div>
@if ($flash = session('toast'))
    <script type="application/json" id="session-toast">@json($flash)</script>
@endif

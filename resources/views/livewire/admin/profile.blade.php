<div class="mx-auto max-w-5xl">
    <h1 class="text-3xl font-extrabold">{{ __('site.admin.nav.profile') }}</h1>
    @if ($saved)
        <p class="mt-3 rounded-xl bg-accent/10 px-4 py-3 text-sm font-semibold text-accent">{{ __('site.admin.saved') }}</p>
    @endif
    <form wire:submit="save" class="mt-6 grid gap-8">
        <section class="surface grid gap-4 p-5">
            <div class="grid gap-4 md:grid-cols-2">
                <label class="grid gap-2 text-sm font-semibold">Name<input class="field" wire:model="full_name"></label>
                <label class="grid gap-2 text-sm font-semibold">Handle<input class="field" wire:model="handle"></label>
                <label class="grid gap-2 text-sm font-semibold">Email<input class="field" type="email" wire:model="public_email"></label>
                <label class="grid gap-2 text-sm font-semibold">Phone<input class="field" wire:model="phone"></label>
                <label class="grid gap-2 text-sm font-semibold md:col-span-2">Address<input class="field" wire:model="address"></label>
                <label class="grid gap-2 text-sm font-semibold">City<input class="field" wire:model="city"></label>
                <label class="grid gap-2 text-sm font-semibold">Country<input class="field" wire:model="country"></label>
                <label class="grid gap-2 text-sm font-semibold">Birth date<input class="field" type="date" wire:model="birth_date"></label>
            </div>
            <div class="grid gap-3">
                @if ($portrait)
                    <img src="{{ $portrait->temporaryUrl() }}" alt="" class="size-28 rounded-2xl object-cover">
                @elseif ($settings?->portraitUrl())
                    <img src="{{ $settings->portraitUrl() }}" alt="" class="size-28 rounded-2xl object-cover">
                @endif
                <label class="grid gap-2 text-sm font-semibold">Portrait
                    <input class="field" type="file" wire:model="portrait" accept="image/jpeg,image/png,image/webp,image/gif">
                </label>
                <p wire:loading wire:target="portrait" class="text-sm text-muted">{{ __('site.admin.uploading') }}</p>
                @error('portrait') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
        </section>

        <section class="surface grid gap-4 p-5">
            <x-admin.locales label="Nationality" model="nationality" />
            <x-admin.locales label="Role" model="role_label" />
            <x-admin.locales label="Tagline" model="tagline" :area="true" />
            <x-admin.locales label="Short about" model="about_short" :area="true" />
            <x-admin.locales label="Long about" model="about_long" :area="true" />
            <x-admin.locales label="Availability" model="availability" :area="true" />
        </section>

        <section class="surface grid gap-4 p-5">
            <h2 class="font-extrabold">Links</h2>
            <div class="grid gap-4 md:grid-cols-2">
                <label class="grid gap-2 text-sm font-semibold">GitHub<input class="field" wire:model="github_url"></label>
                <label class="grid gap-2 text-sm font-semibold">LinkedIn<input class="field" wire:model="linkedin_url"></label>
                <label class="grid gap-2 text-sm font-semibold">Xing<input class="field" wire:model="xing_url"></label>
                <label class="grid gap-2 text-sm font-semibold">Website<input class="field" wire:model="website_url"></label>
                <label class="grid gap-2 text-sm font-semibold">X<input class="field" wire:model="x_url"></label>
            </div>
        </section>

        <section class="surface grid gap-4 p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-extrabold">{{ __('site.cv.languages') }}</h2>
                <x-action-button class="btn-ghost" wire:click="addLanguage" target="addLanguage">+</x-action-button>
            </div>
            @foreach ($spoken_languages as $index => $language)
                <div class="grid gap-3 rounded-2xl border border-line p-4">
                    <x-admin.locales label="Name" model="spoken_languages.{{ $index }}.name" />
                    <x-admin.locales label="Level" model="spoken_languages.{{ $index }}.level" />
                    <x-action-button class="border-0 bg-transparent p-0 text-sm text-red-500" wire:click="removeLanguage({{ $index }})" target="removeLanguage">Remove</x-action-button>
                </div>
            @endforeach
        </section>

        <section class="surface grid gap-4 p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-extrabold">Highlights</h2>
                <x-action-button class="btn-ghost" wire:click="addHighlight" target="addHighlight">+</x-action-button>
            </div>
            @foreach ($highlights as $index => $item)
                <div class="grid gap-3 rounded-2xl border border-line p-4">
                    <label class="grid gap-2 text-sm font-semibold">Icon<input class="field" wire:model="highlights.{{ $index }}.icon"></label>
                    <x-admin.locales label="Title" model="highlights.{{ $index }}.title" />
                    <x-admin.locales label="Body" model="highlights.{{ $index }}.body" :area="true" />
                    <x-action-button class="border-0 bg-transparent p-0 text-sm text-red-500" wire:click="removeHighlight({{ $index }})" target="removeHighlight">Remove</x-action-button>
                </div>
            @endforeach
        </section>

        <section class="surface grid gap-4 p-5">
            <h2 class="font-extrabold">SEO</h2>
            <x-admin.locales label="Site title" model="seo_title" />
            <x-admin.locales label="Site description" model="seo_description" :area="true" />
            <x-admin.locales label="Keywords" model="seo_keywords" :area="true" />
            @foreach ($pages as $key => $page)
                <div class="grid gap-3 rounded-2xl border border-line p-4">
                    <h3 class="font-bold uppercase">{{ $key }}</h3>
                    <x-admin.locales label="Title" model="pages.{{ $key }}.title" />
                    <x-admin.locales label="Description" model="pages.{{ $key }}.description" :area="true" />
                </div>
            @endforeach
        </section>

        <x-action-button type="submit" class="btn-primary w-fit" target="portrait,save">{{ __('site.admin.save') }}</x-action-button>
    </form>
</div>

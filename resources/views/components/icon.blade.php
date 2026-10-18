@props(['name'])

<svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.75', 'aria-hidden' => 'true']) }}>
    @switch($name)
        @case('arrow')
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6" />
            @break
        @case('sun')
            <circle cx="12" cy="12" r="3.5" />
            <path stroke-linecap="round" d="M12 3v2M12 19v2M3 12h2M19 12h2M5.2 5.2l1.4 1.4M17.4 17.4l1.4 1.4M18.8 5.2l-1.4 1.4M6.6 17.4l-1.4 1.4" />
            @break
        @case('moon')
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 14.5A6.5 6.5 0 0 1 9.2 5 6.5 6.5 0 1 0 16 14.5Z" />
            @break
        @case('menu')
            <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h10" />
            @break
        @case('close')
            <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
            @break
        @case('window')
            <rect x="3.5" y="4.5" width="17" height="15" rx="2.5" />
            <path stroke-linecap="round" d="M3.5 9h17" />
            @break
        @case('car')
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 15v2.2a1 1 0 0 0 1 1h1.2a1 1 0 0 0 1-1V16h9.6v1.2a1 1 0 0 0 1 1H19a1 1 0 0 0 1-1V15l-1.4-4.2A2 2 0 0 0 16.7 9.4H7.3a2 2 0 0 0-1.9 1.4L4 15Z" />
            <path stroke-linecap="round" d="M7.2 9.4 8.2 6.8A2 2 0 0 1 10 5.5h4a2 2 0 0 1 1.8 1.3l1 2.6" />
            @break
        @case('api')
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 8 4.5 12 8 16M16 8l3.5 4-3.5 4M13 6l-2 12" />
            @break
        @case('chip')
            <rect x="7" y="7" width="10" height="10" rx="2" />
            <path stroke-linecap="round" d="M9 3.5v3M12 3.5v3M15 3.5v3M9 17.5v3M12 17.5v3M15 17.5v3M3.5 9h3M3.5 12h3M3.5 15h3M17.5 9h3M17.5 12h3M17.5 15h3" />
            @break
        @case('pen')
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 20h4l10.2-10.2a2 2 0 0 0 0-2.8l-.2-.2a2 2 0 0 0-2.8 0L4 16v4Z" />
            @break
        @case('tool')
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.5 6.5a3.5 3.5 0 0 0-4.7 4.7L4 17v3h3l5.8-5.8a3.5 3.5 0 0 0 4.7-4.7l-2.2 2.2-2.8-2.8 2-2.2Z" />
            @break
        @case('spark')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.5 13.6 9 19 10.5 13.6 12 12 17.5 10.4 12 5 10.5 10.4 9 12 3.5Z" />
            @break
        @case('target')
            <circle cx="12" cy="12" r="7.5" />
            <circle cx="12" cy="12" r="3" />
            <path stroke-linecap="round" d="M12 2.5V5M12 19v2.5M2.5 12H5M19 12h2.5" />
            @break
        @case('globe')
            <circle cx="12" cy="12" r="8" />
            <path stroke-linecap="round" d="M4 12h16M12 4c2.2 2.4 3.3 5 3.3 8s-1.1 5.6-3.3 8c-2.2-2.4-3.3-5-3.3-8s1.1-5.6 3.3-8Z" />
            @break
        @case('mail')
            <rect x="3.5" y="5.5" width="17" height="13" rx="2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8 6 8-6" />
            @break
        @case('check')
            <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 5 5 9-10" />
            @break
    @endswitch
</svg>

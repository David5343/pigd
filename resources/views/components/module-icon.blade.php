@props(['name'])

<svg {{ $attributes->merge(['class' => 'h-5 w-5 shrink-0']) }} viewBox="0 0 24 24" fill="none"
    stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('coordination')
            <rect x="3.5" y="3.5" width="7" height="7" rx="1.5" />
            <rect x="13.5" y="3.5" width="7" height="7" rx="1.5" />
            <rect x="3.5" y="13.5" width="7" height="7" rx="1.5" />
            <rect x="13.5" y="13.5" width="7" height="7" rx="1.5" />
        @break

        @case('administration')
            <path d="M4 20.5h16M6.5 20.5V7l5.5-3.5L17.5 7v13.5" />
            <path d="M9 9.5h.01M15 9.5h.01M9 13h.01M15 13h.01M10 20.5v-4h4v4" />
        @break

        @case('legal')
            <path d="M12 3v17M7 21h10M5 6h14M7 6l-4 7h8L7 6Zm10 0-4 7h8l-4-7Z" />
        @break

        @case('medical')
            <path d="M12 21s-8.5-4.8-8.5-11A4.5 4.5 0 0 1 12 7.2 4.5 4.5 0 0 1 20.5 10c0 6.2-8.5 11-8.5 11Z" />
            <path d="M12 9v6M9 12h6" />
        @break

        @case('human-resources')
            <circle cx="9" cy="8" r="3.25" />
            <path d="M3.5 20a5.5 5.5 0 0 1 11 0M16 5.2a3.2 3.2 0 0 1 0 6.2M17 14a5 5 0 0 1 3.5 4.8" />
        @break

        @case('finance')
            <path d="M3.5 20.5h17M5.5 17V11h4v6M10 17V5h4v12M14.5 17V8h4v9" />
        @break

        @case('materials')
            <path d="m12 3 9 5-9 5-9-5 9-5Z" />
            <path d="M3 8v9l9 5 9-5V8M12 13v9" />
        @break

        @case('benefits')
            <path d="M20.5 8.8c0 5.4-8.5 10.2-8.5 10.2S3.5 14.2 3.5 8.8A4.3 4.3 0 0 1 12 7.1a4.3 4.3 0 0 1 8.5 1.7Z" />
            <path d="M8.5 11.5h2l1-2.5 1.5 5 1-2.5h1.5" />
        @break
    @endswitch
</svg>

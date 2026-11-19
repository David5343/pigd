<div class="fixed bottom-4 left-4 z-50" x-data="{ open: false }" @click.away="open = false"
    @keydown.escape.window="open = false">
    <div x-show="open" x-cloak x-transition
        class="absolute bottom-full left-0 mb-3 w-72 max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/20">
        <div class="flex items-center gap-3 px-4 py-4">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <img class="h-10 w-10 shrink-0 rounded-full object-cover ring-2 ring-teal-100"
                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
            @else
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-teal-700 text-sm font-bold text-white">
                    {{ str(mb_substr(Auth::user()->name, 0, 1))->upper() }}
                </span>
            @endif
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                <p class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <div class="border-t border-slate-100 py-1">
            <a href="{{ route('profile.show') }}"
                class="block px-4 py-2.5 text-sm text-slate-700 transition hover:bg-teal-50 hover:text-teal-800">
                {{ __('Perfil y seguridad') }}
            </a>
            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <a href="{{ route('api-tokens.index') }}"
                    class="block px-4 py-2.5 text-sm text-slate-700 transition hover:bg-teal-50 hover:text-teal-800">
                    {{ __('API Tokens') }}
                </a>
            @endif
        </div>

        <div class="border-t border-slate-100 py-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="block w-full px-4 py-2.5 text-left text-sm font-medium text-rose-700 transition hover:bg-rose-50">
                    {{ __('Cerrar sesión') }}
                </button>
            </form>
        </div>
    </div>

    <button type="button" @click="open = !open" :aria-expanded="open.toString()"
        aria-label="{{ __('Abrir menú de usuario') }}"
        class="flex max-w-[calc(100vw-2rem)] items-center gap-2 rounded-full border border-white/20 bg-[#075e56] py-2 ps-2 pe-4 text-sm font-medium text-white shadow-lg shadow-slate-900/20 transition hover:bg-[#064f49] focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 focus-visible:ring-offset-2">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <img class="h-9 w-9 shrink-0 rounded-full object-cover ring-2 ring-white/40"
                src="{{ Auth::user()->profile_photo_url }}" alt="">
        @else
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/15 text-xs font-bold text-white">
                {{ str(mb_substr(Auth::user()->name, 0, 1))->upper() }}
            </span>
        @endif
        <span class="max-w-[calc(100vw-7rem)] truncate">{{ Auth::user()->name }}</span>
        <svg class="h-4 w-4 shrink-0 text-teal-100 transition-transform" :class="{ 'rotate-180': open }"
            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
                d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z"
                clip-rule="evenodd" />
        </svg>
    </button>
</div>

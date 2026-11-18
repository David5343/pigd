<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
</head>

<body class="bg-slate-100 font-sans antialiased text-slate-800">
    <x-banner />
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-[1440px] items-center gap-4 px-4 py-3 sm:gap-6 sm:px-6 lg:px-8">
                <a href="{{ route('dashboard') }}" class="shrink-0">
                    <img src="{{ asset('images/logo_fide.png') }}" alt="Fideicomiso del Sector Policial"
                        class="h-14 w-14 object-contain sm:h-16 sm:w-16">
                </a>
                <span aria-hidden="true" class="h-12 w-0 shrink-0 border-l-2 border-slate-400 sm:h-14"></span>
                <div class="min-w-0 flex-1 text-left">
                    <h1 class="text-lg font-bold leading-tight tracking-tight text-slate-900 sm:text-2xl lg:text-3xl">
                        Plataforma Institucional de Gestión de Datos
                    </h1>
                    <p class="mt-1 max-w-4xl text-[9px] font-semibold leading-snug text-slate-500 sm:text-xs lg:text-sm">
                        Fideicomiso de Prestaciones de Seguridad Social para los Trabajadores del Sector Policial Operativo al Servicio del Poder Ejecutivo del Estado de Chiapas
                    </p>
                </div>
                <img src="{{ asset('images/gob_chiapas.png') }}" alt="Gobierno del Estado de Chiapas"
                    class="h-14 w-auto shrink-0 object-contain sm:h-16 lg:h-[4.5rem]">
            </div>
        </header>

        <div class="sticky top-0 z-40">
            @livewire('navigation-menu')
        </div>

        @if (isset($header))
            <header class="mx-auto max-w-[1440px] px-4 pt-3 sm:px-6 lg:px-8">
                <div class="rounded-xl border border-slate-200 bg-white px-4 py-2 shadow-sm sm:px-5">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="mx-auto max-w-[1440px] px-4 py-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>

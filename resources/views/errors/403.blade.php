<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#075e56">
    <title>Acceso no autorizado | {{ config('app.name', 'PIGD') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-slate-100 font-sans antialiased text-slate-800">
    <main class="grid min-h-screen place-items-center px-4 py-8">
        <section class="w-full max-w-4xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-900/10">
            <header class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-4 sm:px-8">
                <img src="{{ asset('images/logo_fide.png') }}" alt="Fideicomiso del Sector Policial"
                    class="h-12 w-12 shrink-0 object-contain sm:h-14 sm:w-14">
                <div class="min-w-0 flex-1 border-l-2 border-slate-300 pl-4 text-left sm:pl-6">
                    <p class="text-sm font-bold leading-tight text-slate-900 sm:text-lg">
                        Plataforma Institucional de Gestión de Datos
                    </p>
                    <p class="mt-1 hidden text-[10px] leading-snug text-slate-500 sm:block sm:text-xs">
                        Fideicomiso de Prestaciones de Seguridad Social para los Trabajadores del Sector Policial Operativo al Servicio del Poder Ejecutivo del Estado de Chiapas
                    </p>
                </div>
                <img src="{{ asset('images/gob_chiapas.png') }}" alt="Gobierno del Estado de Chiapas"
                    class="h-12 w-auto shrink-0 object-contain sm:h-14">
            </header>

            <div class="px-6 py-10 text-center sm:px-12 sm:py-14">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-rose-50 text-rose-700 ring-1 ring-rose-100">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 3 21 20H3L12 3Z" />
                        <path d="M12 9v4M12 17h.01" />
                    </svg>
                </div>

                <p class="mt-6 text-sm font-bold uppercase tracking-[0.2em] text-teal-700">Error 403</p>
                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Acceso no autorizado
                </h1>
                <p class="mx-auto mt-4 max-w-2xl text-sm leading-6 text-slate-600 sm:text-base">
                    No tienes permisos para consultar el recurso solicitado. Si consideras que deberías tener acceso,
                    comunícate con la persona administradora del sistema o con el área responsable.
                </p>

                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center rounded-xl bg-[#075e56] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#064f49] focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2">
                            Volver al inicio
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-xl bg-[#075e56] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#064f49] focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2">
                            Ir a iniciar sesión
                        </a>
                    @endauth
                </div>

                <p class="mt-8 text-xs text-slate-400">
                    Código de respuesta: 403 · {{ config('app.name', 'PIGD') }}
                </p>
            </div>
        </section>
    </main>
</body>

</html>

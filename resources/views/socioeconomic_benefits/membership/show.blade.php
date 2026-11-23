<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl leading-tight text-[#651F34]">
                Prestaciones Socioeconómicas / Titulares / Expediente electrónico
            </h2>
            <a href="{{ route('membership.index') }}"
                class="inline-flex items-center rounded-md border border-[#E7DFD9] bg-white px-4 py-2 text-sm font-medium text-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                Volver al listado
            </a>
        </div>
    </x-slot>

    @php
        $estatus = $estatusAfiliacion ?: 'Sin estatus de afiliación';
        $claseEstatus = match (mb_strtolower($estatus)) {
            'activo' => 'bg-green-100 text-green-800 ring-green-600/20',
            'preafiliado' => 'bg-yellow-100 text-yellow-800 ring-yellow-600/20',
            'baja', 'baja por aplicar' => 'bg-red-100 text-red-800 ring-red-600/20',
            default => 'bg-gray-100 text-gray-700 ring-gray-500/20',
        };
    @endphp

    <main class="min-h-screen bg-[#F7F3EC] py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div x-data="{ fotoAbierta: false }">
                <section class="overflow-hidden rounded-xl border border-[#E7DFD9] bg-white shadow-sm">
                    <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:p-6">
                        <button type="button" @click="fotoAbierta = true"
                            :aria-expanded="fotoAbierta.toString()" aria-haspopup="dialog"
                            aria-label="Ampliar fotografía de {{ $nombreTitular ?: 'titular' }}"
                            class="cursor-zoom-in self-center rounded-md focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2 sm:self-auto">
                            <img src="{{ $fotoUrl }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/icono_no_imagen.png') }}';"
                                alt="Fotografía de {{ $nombreTitular ?: 'titular' }}"
                                class="h-32 w-24 rounded-md border border-[#E7DFD9] object-cover">
                        </button>

                        <div class="min-w-0 flex-1 text-center sm:text-left">
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8A6670]">Expediente electrónico</p>
                            <h1 class="mt-1 text-2xl font-bold text-[#651F34] sm:text-3xl">
                                {{ $nombreTitular ?: 'Nombre no disponible' }}
                            </h1>
                            <p class="mt-3 text-sm text-gray-700">
                                <span class="font-semibold text-gray-900">Folio de afiliación:</span>
                                {{ $folioAfiliacion ?: 'No disponible' }}
                            </p>
                        </div>

                        <div class="shrink-0 self-center sm:self-start">
                            <span class="inline-flex items-center rounded-full px-3 py-1.5 text-sm font-semibold ring-1 ring-inset {{ $claseEstatus }}">
                                {{ $estatus }}
                            </span>
                        </div>
                    </div>
                </section>

                <div x-cloak x-show="fotoAbierta" x-transition.opacity
                    @click.self="fotoAbierta = false" @keydown.escape.window="fotoAbierta = false"
                    role="dialog" aria-modal="true" aria-label="Fotografía ampliada"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 p-4">
                    <div class="relative">
                        <button type="button" @click="fotoAbierta = false" aria-label="Cerrar fotografía ampliada"
                            class="absolute -right-3 -top-3 z-10 inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-gray-700 shadow-lg transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 0 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                            </svg>
                        </button>
                        <img src="{{ $fotoUrl }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/icono_no_imagen.png') }}';"
                            alt="Fotografía ampliada de {{ $nombreTitular ?: 'titular' }}"
                            class="block h-auto max-h-[90vh] w-auto max-w-[90vw] rounded-lg bg-white object-contain shadow-2xl">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <section class="rounded-xl border border-[#E7DFD9] bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="border-b border-[#E7DFD9] pb-3 text-lg font-semibold text-[#651F34]">
                        Adscripción y afiliación
                    </h2>
                    <dl class="mt-4 space-y-4">
                        @foreach ($datosAdscripcion as $etiqueta => $valor)
                            <div class="grid grid-cols-1 gap-1 sm:grid-cols-[minmax(9rem,0.8fr)_1.2fr] sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500">{{ $etiqueta }}</dt>
                                <dd class="break-words text-sm text-gray-900">
                                    {{ filled($valor) ? $valor : 'No disponible' }}
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </section>

                <section class="rounded-xl border border-[#E7DFD9] bg-white p-5 shadow-sm sm:p-6 lg:col-span-2">
                    <div class="flex flex-wrap items-baseline justify-between gap-3 border-b border-[#E7DFD9] pb-3">
                        <h2 class="text-lg font-semibold text-[#651F34]">Familiares vinculados</h2>
                        <span class="text-sm text-gray-500">{{ $familiares->count() }} registrados</span>
                    </div>

                    @if ($familiares->isNotEmpty())
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-[#E7DFD9] text-left text-sm">
                                <thead class="bg-[#F7F3EC] text-xs uppercase tracking-wide text-gray-600">
                                    <tr>
                                        <th scope="col" class="px-3 py-3 font-semibold">Nombre completo</th>
                                        <th scope="col" class="px-3 py-3 font-semibold">Parentesco</th>
                                        <th scope="col" class="px-3 py-3 font-semibold">Folio</th>
                                        <th scope="col" class="px-3 py-3 font-semibold">Fecha de ingreso</th>
                                        <th scope="col" class="px-3 py-3 font-semibold">Fecha de nacimiento</th>
                                        <th scope="col" class="px-3 py-3 font-semibold">CURP</th>
                                        <th scope="col" class="px-3 py-3 font-semibold">Sexo</th>
                                        <th scope="col" class="px-3 py-3 font-semibold">Capacidades diferentes</th>
                                        <th scope="col" class="px-3 py-3 font-semibold">Estatus</th>
                                        <th scope="col" class="px-3 py-3 text-center font-semibold">Expediente</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#E7DFD9]">
                                    @foreach ($familiares as $familiar)
                                        <tr>
                                            <td class="whitespace-nowrap px-3 py-3 font-medium text-gray-900">{{ $familiar['nombre'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-3 py-3 text-gray-700">{{ $familiar['parentesco'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-3 py-3 text-gray-700">{{ $familiar['folio'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-3 py-3 text-gray-700">{{ $familiar['fecha_ingreso'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-3 py-3 text-gray-700">{{ $familiar['fecha_nacimiento'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-3 py-3 text-gray-700">{{ $familiar['curp'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-3 py-3 text-gray-700">{{ $familiar['sexo'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-3 py-3 text-gray-700">{{ $familiar['capacidades_diferentes'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-3 py-3 text-gray-700">{{ $familiar['estatus'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-3 py-3 text-center">
                                                <button type="button"
                                                    x-on:click="$dispatch('open-medical-beneficiary-expedient', { beneficiaryId: {{ $familiar['id'] }}, origin: 'socioeconomic' })"
                                                    title="Abrir expediente electrónico del familiar"
                                                    aria-label="Abrir expediente electrónico de {{ $familiar['nombre'] ?: 'familiar' }}"
                                                    aria-haspopup="dialog"
                                                    class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13.5 6H19.5m0 0v6m0-6-9 9" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 13.5v4.875A1.875 1.875 0 0 1 17.625 20.25H6.375A1.875 1.875 0 0 1 4.5 18.375V7.125A1.875 1.875 0 0 1 6.375 5.25H11.25" />
                                                    </svg>
                                                    <span class="sr-only">Abrir expediente del familiar</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mt-4 rounded-lg bg-[#F7F3EC] px-4 py-5 text-center text-sm text-gray-600">
                            Este titular no tiene familiares registrados.
                        </p>
                    @endif
                </section>

                @foreach ([
                    'Datos personales y contacto' => $datosPersonales,
                    'Domicilio' => $datosDomicilio,
                ] as $titulo => $datos)
                    <section class="rounded-xl border border-[#E7DFD9] bg-white p-5 shadow-sm sm:p-6">
                        <h2 class="border-b border-[#E7DFD9] pb-3 text-lg font-semibold text-[#651F34]">{{ $titulo }}</h2>
                        <dl class="mt-4 space-y-4">
                            @foreach ($datos as $etiqueta => $valor)
                                <div class="grid grid-cols-1 gap-1 sm:grid-cols-[minmax(9rem,0.8fr)_1.2fr] sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">{{ $etiqueta }}</dt>
                                    <dd class="break-words text-sm text-gray-900">
                                        {{ filled($valor) ? $valor : 'No disponible' }}
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </section>
                @endforeach
            </div>

            <section class="rounded-xl border border-[#E7DFD9] bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-wrap items-baseline justify-between gap-3 border-b border-[#E7DFD9] pb-3">
                    <h2 class="text-lg font-semibold text-[#651F34]">Historial de credenciales</h2>
                    <span class="text-sm text-gray-500">{{ $credenciales->count() }} registros</span>
                </div>

                @if ($credenciales->isNotEmpty())
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#E7DFD9] text-left text-sm">
                            <thead class="bg-[#F7F3EC] text-xs uppercase tracking-wide text-gray-600">
                                <tr>
                                    <th scope="col" class="px-4 py-3 font-semibold">Número de credencial</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Fecha de emisión</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Vigente hasta</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Tipo de vigencia</th>
                                    <th scope="col" class="px-4 py-3 font-semibold">Estatus</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#E7DFD9]">
                                @foreach ($credenciales as $credencial)
                                    @php
                                        $claseEstatusCredencial = match (mb_strtoupper($credencial['estatus'] ?? '')) {
                                            'VIGENTE' => 'bg-green-100 text-green-800',
                                            'VENCIDA' => 'bg-gray-100 text-gray-700',
                                            default => 'bg-yellow-100 text-yellow-800',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">{{ $credencial['numero'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $credencial['emitida'] ?: 'No disponible' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $credencial['vigente_hasta'] ?: 'No disponible' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $credencial['tipo_vigencia'] ?: 'No disponible' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $claseEstatusCredencial }}">
                                                {{ $credencial['estatus'] ?: 'Sin estatus' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="mt-4 rounded-lg bg-[#F7F3EC] px-4 py-5 text-center text-sm text-gray-600">
                        Este titular no tiene credenciales registradas.
                    </p>
                @endif
            </section>
        </div>
    </main>

    <livewire:medical-coordination.beneficiary-expedient-modal />
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Coordinación Médica / Titulares / Ficha
            </h2>
            <a href="{{ route('membership_medical.index') }}"
                class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Volver al listado
            </a>
        </div>
    </x-slot>

    @php
        $nombreTitular = collect([$titular->last_name_1, $titular->last_name_2, $titular->name])
            ->filter()
            ->implode(' ');
        $estatusAfiliacion = $titular->affiliationStatus?->name ?? 'Sin estatus de afiliación';
        $claseEstatus = match ($estatusAfiliacion) {
            'Activo' => 'bg-green-100 text-green-800 ring-green-600/20',
            'Preafiliado' => 'bg-yellow-100 text-yellow-800 ring-yellow-600/20',
            'Baja', 'Baja por Aplicar' => 'bg-red-100 text-red-800 ring-red-600/20',
            default => 'bg-gray-100 text-gray-700 ring-gray-500/20',
        };

        $datosAfiliacion = [
            'Folio de afiliación' => $titular->file_number,
            'Número de empleado' => $titular->employee_number,
            'Dependencia' => $titular->subdependency?->dependency?->name,
            'Subdependencia' => $titular->subdependency?->name,
            'Categoría' => $titular->rank?->name,
            'Fecha de ingreso' => $titular->start_date,
            'Lugar de trabajo' => $titular->workplaceCounty?->name,
            'Motivo de registro' => $titular->register_motive,
            'Observaciones' => $titular->observations,
        ];

        $datosPersonales = [
            'Fecha de nacimiento' => $titular->birthday,
            'Lugar de nacimiento' => $titular->birthplaceCounty?->name,
            'Sexo' => $titular->sex,
            'Estado civil' => $titular->marital_status,
            'RFC' => $titular->rfc,
            'CURP' => $titular->curp,
            'Teléfono' => $titular->phone,
            'Correo electrónico' => $titular->email,
            'Tipo de sangre' => $titular->blood_type,
        ];

        $datosDomicilio = [
            'Estado' => $titular->county?->state?->name,
            'Municipio' => $titular->county?->name,
            'Colonia' => $titular->neighborhood,
            'Tipo de vialidad' => $titular->roadway_type,
            'Calle' => $titular->street,
            'Número exterior' => $titular->outdoor_number,
            'Número interior' => $titular->interior_number,
            'Código postal' => $titular->cp,
            'Localidad' => $titular->locality,
        ];

        $datosHistorial = [
            'Fecha de baja en dependencia' => $titular->inactive_date_dependency,
            'Fecha de baja en sistema' => $titular->inactive_date,
            'Motivo de baja' => $titular->inactive_motive,
            'Fecha de reingreso' => $titular->reentry_date,
        ];
        $mostrarHistorial = collect($datosHistorial)->contains(fn ($valor) => filled($valor));
    @endphp

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
                <div class="flex flex-col gap-5 p-6 sm:flex-row sm:items-center">
                    <img
                        src="{{ $titular->photo ? asset('photo/insureds/' . $titular->file_number . '.jpg') : asset('images/icono_no_imagen.png') }}"
                        onerror="this.onerror=null;this.src='{{ asset('images/icono_no_imagen.png') }}';"
                        alt="Fotografía de {{ $nombreTitular ?: 'titular' }}"
                        class="h-28 w-28 shrink-0 rounded-full object-cover ring-2 ring-gray-100">

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium uppercase tracking-wide text-gray-500">Ficha de titular</p>
                        <h1 class="mt-1 text-2xl font-semibold text-gray-900">
                            {{ $nombreTitular ?: 'Nombre no disponible' }}
                        </h1>
                        <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-gray-600">
                            <span><strong>Folio:</strong> {{ $titular->file_number ?: 'No disponible' }}</span>
                            <span><strong>Número de empleado:</strong> {{ $titular->employee_number ?: 'No disponible' }}</span>
                        </div>
                    </div>

                    <div class="shrink-0">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold ring-1 ring-inset {{ $claseEstatus }}">
                            {{ $estatusAfiliacion }}
                        </span>
                    </div>
                </div>
            </section>

            <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Adscripción y afiliación</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($datosAfiliacion as $etiqueta => $valor)
                        <div class="rounded-lg bg-gray-50 p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $etiqueta }}</dt>
                            <dd class="mt-1 break-words text-sm text-gray-900">{{ filled($valor) ? $valor : 'No disponible' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>

            <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Datos personales y contacto</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($datosPersonales as $etiqueta => $valor)
                        <div class="rounded-lg bg-gray-50 p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $etiqueta }}</dt>
                            <dd class="mt-1 break-words text-sm text-gray-900">{{ filled($valor) ? $valor : 'No disponible' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>

            <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Domicilio</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($datosDomicilio as $etiqueta => $valor)
                        <div class="rounded-lg bg-gray-50 p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $etiqueta }}</dt>
                            <dd class="mt-1 break-words text-sm text-gray-900">{{ filled($valor) ? $valor : 'No disponible' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>

            @if ($mostrarHistorial)
                <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Bajas y reingreso</h2>
                    <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($datosHistorial as $etiqueta => $valor)
                            <div class="rounded-lg bg-gray-50 p-4">
                                <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $etiqueta }}</dt>
                                <dd class="mt-1 break-words text-sm text-gray-900">{{ filled($valor) ? $valor : 'No disponible' }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </section>
            @endif

            <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                <div class="flex flex-wrap items-baseline justify-between gap-2">
                    <h2 class="text-lg font-semibold text-gray-900">Familiares vinculados</h2>
                    <span class="text-sm text-gray-500">{{ $titular->beneficiaries->count() }} registrados</span>
                </div>

                @if ($titular->beneficiaries->isNotEmpty())
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Familiar</th>
                                    <th scope="col" class="px-4 py-3">Parentesco</th>
                                    <th scope="col" class="px-4 py-3">Fecha de ingreso</th>
                                    <th scope="col" class="px-4 py-3">Fecha de nacimiento</th>
                                    <th scope="col" class="px-4 py-3">CURP</th>
                                    <th scope="col" class="px-4 py-3">Estado de afiliación</th>
                                    <th scope="col" class="px-4 py-3">Sexo</th>
                                    <th scope="col" class="px-4 py-3">Capacidades diferentes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($titular->beneficiaries as $familiar)
                                    @php
                                        $nombreFamiliar = collect([$familiar->last_name_1, $familiar->last_name_2, $familiar->name])
                                            ->filter()
                                            ->implode(' ');
                                    @endphp
                                    <tr class="align-top">
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <div class="font-medium text-gray-900">{{ $nombreFamiliar ?: 'Nombre no disponible' }}</div>
                                            <div class="mt-1 text-xs text-gray-500">Folio: {{ $familiar->file_number ?: 'No disponible' }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $familiar->relationship ?: 'No disponible' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $familiar->start_date ?: 'No disponible' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $familiar->birthday ?: 'No disponible' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $familiar->curp ?: 'No disponible' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $familiar->affiliate_status ?: 'No disponible' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $familiar->sex ?: 'No disponible' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $familiar->disabled_person ?: 'No disponible' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="mt-4 rounded-lg bg-gray-50 px-4 py-6 text-center text-sm text-gray-600">
                        Este titular no tiene familiares registrados.
                    </p>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
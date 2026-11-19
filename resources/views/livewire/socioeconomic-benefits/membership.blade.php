<div>
    <div class="border-b border-gray-200 bg-white p-6 lg:p-8">
        <h1 class="text-2xl font-medium text-gray-900">Estadísticas rápidas</h1>
        <p class="mt-3 text-gray-500 leading-relaxed">Titulares</p>

        <div wire:poll.5s class="overflow-x-auto rounded-lg border border-neutral-200 dark:border-neutral-700">
            <table class="w-full text-left text-sm text-neutral-700 dark:text-neutral-300">
                <thead class="bg-neutral-100 text-xs uppercase text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300">
                    <tr>
                        <th scope="col" class="px-4 py-3">Estadística</th>
                        <th scope="col" class="px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-4 py-3">Preafiliados</td>
                        <td class="px-4 py-3 text-right font-semibold tabular-nums">{{ $this->insuredPreafiliados }}</td>
                    </tr>
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-4 py-3">Bajas</td>
                        <td class="px-4 py-3 text-right font-semibold tabular-nums">{{ $this->insuredBajas }}</td>
                    </tr>
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-4 py-3">Bajas por aplicar</td>
                        <td class="px-4 py-3 text-right font-semibold tabular-nums">{{ $this->insuredBajasPendientes }}</td>
                    </tr>
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-4 py-3">Total de hombres</td>
                        <td class="px-4 py-3 text-right font-semibold tabular-nums">{{ $this->insuredTotalHombres }}</td>
                    </tr>
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-4 py-3">Total de mujeres</td>
                        <td class="px-4 py-3 text-right font-semibold tabular-nums">{{ $this->insuredTotalMujeres }}</td>
                    </tr>
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-4 py-3">Fiscalía General del Estado</td>
                        <td class="px-4 py-3 text-right font-semibold tabular-nums">{{ $this->InsuredTotalFGE }}</td>
                    </tr>
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-4 py-3">Secretaría de Seguridad del Pueblo</td>
                        <td class="px-4 py-3 text-right font-semibold tabular-nums">{{ $this->InsuredTotalSSP }}</td>
                    </tr>
                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800">
                        <td class="px-4 py-3">Activos</td>
                        <td class="px-4 py-3 text-right font-semibold tabular-nums">{{ $this->insuredActivos }}</td>
                    </tr>
                </tbody>
                <tfoot class="border-t-2 border-neutral-300 bg-neutral-100 font-bold text-neutral-900 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                    <tr>
                        <td class="px-4 py-3">Total de registros</td>
                        <td class="px-4 py-3 text-right tabular-nums">{{ $this->insuredTotal }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-5 flex justify-end">
            <a href="{{ route('membership.create') }}"
                class="inline-flex items-center gap-2 rounded bg-neutral-100 px-6 py-2.5 text-xs font-medium uppercase text-neutral-700 transition hover:bg-blue-300 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-neutral-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                Nuevo titular
            </a>
        </div>

        <section class="mt-5" aria-label="Listado de titulares">
            <div class="mb-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <label for="insured-search" class="sr-only">Buscar titulares</label>
                <input wire:model.live="search" id="insured-search" type="search"
                    class="block w-full rounded border border-neutral-200 bg-transparent px-3 py-2 text-base text-surface outline-none transition placeholder:text-neutral-500 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:border-white/10 dark:text-white dark:placeholder:text-neutral-200 sm:min-w-0 sm:flex-1"
                    placeholder="Buscar por folio, número de empleado, nombre, RFC o CURP"
                    aria-label="Buscar titulares por folio, número de empleado, nombre, RFC o CURP" />
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                    <label for="insured-rows">Mostrar</label>
                    <select wire:model.live="numberRows" id="insured-rows"
                        class="rounded border border-neutral-200 bg-white px-2 py-2 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-white/10 dark:bg-neutral-800 dark:text-white">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>por página</span>
                </div>
            </div>

            <div wire:loading.delay class="mb-2 text-sm text-neutral-500" role="status">Actualizando listado…</div>
            <div class="overflow-x-auto rounded-lg border border-neutral-200 dark:border-white/10">
                <table class="min-w-full text-left text-sm text-surface dark:text-white">
                    <thead class="border-b border-neutral-200 bg-neutral-50 font-medium dark:border-white/10 dark:bg-neutral-800">
                        <tr>
                            <th scope="col" class="whitespace-nowrap px-4 py-3">#</th>
                            <th scope="col" class="whitespace-nowrap px-4 py-3">Folio</th>
                            <th scope="col" class="px-4 py-3">Nombre</th>
                            <th scope="col" class="whitespace-nowrap px-4 py-3">RFC</th>
                            <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Estatus</th>
                            <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Editar</th>
                            <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Expediente</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-white/10">
                        @forelse ($lista as $item)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/60">
                                <td class="whitespace-nowrap px-4 py-3 font-medium">{{ $item->id }}</td>
                                <td class="whitespace-nowrap px-4 py-3">{{ $item->file_number }}</td>
                                <td class="px-4 py-3">{{ trim($item->last_name_1 . ' ' . $item->last_name_2 . ' ' . $item->name) }}</td>
                                <td class="whitespace-nowrap px-4 py-3">{{ $item->rfc }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    @php
                                        $estatus = trim($item->affiliationStatus?->name ?? '');
                                        $estiloEstatus = match (mb_strtolower($estatus)) {
                                            'preafiliado' => ['badge' => 'border-amber-200 bg-amber-50 text-amber-800', 'dot' => 'bg-amber-500'],
                                            'activo' => ['badge' => 'border-green-200 bg-green-50 text-green-800', 'dot' => 'bg-green-500'],
                                            'bloqueado' => ['badge' => 'border-gray-200 bg-gray-100 text-gray-700', 'dot' => 'bg-gray-500'],
                                            'baja' => ['badge' => 'border-red-200 bg-red-50 text-red-800', 'dot' => 'bg-red-500'],
                                            'baja por aplicar' => ['badge' => 'border-orange-200 bg-orange-50 text-orange-800', 'dot' => 'bg-orange-500'],
                                            default => ['badge' => 'border-slate-200 bg-slate-50 text-slate-700', 'dot' => 'bg-slate-400'],
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold shadow-sm {{ $estiloEstatus['badge'] }}">
                                        <span class="h-2 w-2 rounded-full ring-2 ring-white {{ $estiloEstatus['dot'] }}" aria-hidden="true"></span>
                                        {{ $estatus ?: 'Sin estatus de afiliación' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    <a href="{{ url('socioeconomic_benefits/membership/' . $item->id . '/edit') }}"
                                        aria-label="Editar titular {{ trim($item->last_name_1 . ' ' . $item->last_name_2 . ' ' . $item->name) }}"
                                        class="inline-flex items-center justify-center rounded-lg p-2 text-neutral-600 transition hover:bg-neutral-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-neutral-300 dark:hover:bg-neutral-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        <span class="sr-only">Editar</span>
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    <a href="{{ route('membership.show', $item->id) }}"
                                        title="Abrir expediente"
                                        aria-label="Abrir expediente de {{ trim($item->last_name_1 . ' ' . $item->last_name_2 . ' ' . $item->name) }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.25 8V6.75A1.75 1.75 0 0 1 5 5h5l2 2h7A1.75 1.75 0 0 1 20.75 8.75V10" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.25 9.75h17.5v8.5A1.75 1.75 0 0 1 19 20H5a1.75 1.75 0 0 1-1.75-1.75z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 13.25h10m-10 3h6" />
                                        </svg>
                                        <span class="sr-only">Abrir expediente</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    No se encontraron titulares que coincidan con la búsqueda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $lista->links('livewire.socioeconomic-benefits.pagination') }}
        </section>
    </div>
</div>

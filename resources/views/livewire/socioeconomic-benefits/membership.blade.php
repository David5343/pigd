<div class="bg-white p-4 lg:p-5">
    <section aria-label="Listado de titulares">
        <div class="mb-4 flex justify-end">
            <button type="button" wire:click="openCreateModal"
                class="inline-flex items-center gap-2 rounded bg-neutral-100 px-6 py-2.5 text-xs font-medium uppercase text-neutral-700 transition hover:bg-blue-300 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-neutral-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                Nuevo titular
            </button>
        </div>
            @if ($successMessage)
                <div class="mb-4 flex items-center justify-between gap-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"
                    role="status">
                    <span>{{ $successMessage }}</span>
                    <button type="button" wire:click="$set('successMessage', null)"
                        class="font-semibold hover:text-green-950" aria-label="Cerrar mensaje">
                        &times;
                    </button>
                </div>
            @endif
            <div class="mb-5 rounded-xl border border-[#E7DFD9] bg-[#F7F3EC] p-4 sm:p-5"
                aria-labelledby="insured-search-heading">
                <div class="mb-3 flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#651F34] shadow-sm">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M9 3.5a5.5 5.5 0 1 0 3.46 9.78l3.63 3.63a.75.75 0 1 0 1.06-1.06l-3.63-3.63A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <div>
                        <h2 id="insured-search-heading" class="text-sm font-semibold text-[#651F34]">
                            Buscar titulares
                        </h2>
                        <p class="mt-0.5 text-xs text-slate-600">
                            Filtra por folio, número de empleado, nombre, RFC o CURP.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <label for="insured-search" class="sr-only">Buscar titulares</label>
                    <input wire:model.live="search" id="insured-search" type="search"
                        class="block w-full min-w-0 flex-1 rounded-lg border border-[#D9CBC5] bg-white px-3 py-2.5 text-base text-surface outline-none transition placeholder:text-neutral-500 focus:border-[#651F34] focus:ring-2 focus:ring-[#651F34]/20 sm:max-w-2xl"
                        placeholder="Escribe un criterio de búsqueda"
                        aria-label="Buscar titulares por folio, número de empleado, nombre, RFC o CURP" />
                    <div class="flex shrink-0 items-center gap-2 text-sm text-slate-700 sm:ml-auto">
                        <label for="insured-rows" class="font-medium">Mostrar</label>
                        <select wire:model.live="numberRows" id="insured-rows"
                            class="w-24 shrink-0 rounded-lg border border-[#D9CBC5] bg-white py-2.5 pl-3 pr-8 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>por página</span>
                    </div>
                </div>

                <div wire:loading.delay class="mt-3 text-sm text-slate-500" role="status">
                    Actualizando búsqueda…
                </div>
            </div>

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
                            <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Familiares vinculados</th>
                            <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Historial de credenciales</th>
                            <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Expediente electrónico</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-white/10">
                        @forelse ($lista as $item)
                            @php
                                $nombreTitular = collect([$item->last_name_1, $item->last_name_2, $item->name])
                                    ->filter(fn ($parte) => filled($parte))
                                    ->implode(' ');
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
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/60">
                                <td class="whitespace-nowrap px-4 py-3 font-medium">{{ $item->id }}</td>
                                <td class="whitespace-nowrap px-4 py-3">{{ $item->file_number }}</td>
                                <td class="max-w-xs break-words px-4 py-3">{{ $nombreTitular ?: 'Nombre no disponible' }}</td>
                                <td class="whitespace-nowrap px-4 py-3">{{ $item->rfc }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold shadow-sm {{ $estiloEstatus['badge'] }}">
                                        <span class="h-2 w-2 rounded-full ring-2 ring-white {{ $estiloEstatus['dot'] }}" aria-hidden="true"></span>
                                        {{ $estatus ?: 'Sin estatus de afiliación' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    <a href="{{ url('socioeconomic_benefits/membership/' . $item->id . '/edit') }}"
                                        aria-label="Editar titular {{ $nombreTitular ?: 'sin nombre' }}"
                                        class="inline-flex items-center justify-center rounded-lg p-2 text-neutral-600 transition hover:bg-neutral-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-neutral-300 dark:hover:bg-neutral-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        <span class="sr-only">Editar</span>
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    <button type="button" wire:click="openFamilies({{ $item->id }})"
                                        title="Ver familiares vinculados"
                                        aria-label="Ver familiares vinculados de {{ $nombreTitular ?: 'titular' }}"
                                        aria-haspopup="dialog"
                                        class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.094 9.094 0 0 0 3.742-.9 3.75 3.75 0 0 0-4.992-5.628M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>
                                        <span class="sr-only">Ver familiares vinculados</span>
                                    </button>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    <button type="button" wire:click="openCredentials({{ $item->id }})"
                                        title="Ver historial de credenciales"
                                        aria-label="Ver historial de credenciales de {{ $nombreTitular ?: 'titular' }}"
                                        aria-haspopup="dialog"
                                        class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <rect x="3" y="4.5" width="18" height="15" rx="2.25" />
                                            <circle cx="8.25" cy="10" r="2" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.5 15.5a2.75 2.75 0 0 1 5.5 0m3-5.5h4m-4 3h4m-4 3h2.5" />
                                        </svg>
                                        <span class="sr-only">Ver historial de credenciales</span>
                                    </button>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-center">
                                    <button type="button" wire:click="openExpedient({{ $item->id }})"
                                        title="Abrir expediente electrónico"
                                        aria-label="Abrir expediente electrónico de {{ $nombreTitular ?: 'titular' }}"
                                        aria-haspopup="dialog"
                                        class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.25 8V6.75A1.75 1.75 0 0 1 5 5h5l2 2h7A1.75 1.75 0 0 1 20.75 8.75V10" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.25 9.75h17.5v8.5A1.75 1.75 0 0 1 19 20H5a1.75 1.75 0 0 1-1.75-1.75z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 13.25h10m-10 3h6" />
                                        </svg>
                                        <span class="sr-only">Abrir expediente electrónico</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                    No se encontraron titulares que coincidan con la búsqueda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $lista->links('livewire.socioeconomic-benefits.pagination') }}
        </section>

        <livewire:medical-coordination.insured-expedient-modal />
        <livewire:medical-coordination.insured-families-modal />
        <livewire:medical-coordination.insured-credentials-modal />
        <livewire:medical-coordination.beneficiary-expedient-modal />

        @if ($showingCreateModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-2 sm:p-5"
                wire:click.self="closeCreateModal"
                x-on:keydown.escape.window="$wire.closeCreateModal()"
                role="dialog" aria-modal="true" aria-labelledby="create-insured-modal-title">
                <div class="flex max-h-[95vh] w-full max-w-7xl flex-col overflow-hidden rounded-xl bg-white shadow-2xl"
                    wire:click.stop>
                    <div class="flex shrink-0 items-center justify-between border-b border-slate-200 px-5 py-4 sm:px-7">
                        <h2 id="create-insured-modal-title" class="text-lg font-semibold text-slate-900">
                            Nuevo titular
                        </h2>
                        <button type="button" wire:click="closeCreateModal"
                            class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#651F34]"
                            aria-label="Cerrar formulario">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5" class="h-5 w-5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18" />
                            </svg>
                        </button>
                    </div>
                    <div class="min-h-0 overflow-y-auto">
                        <livewire:socioeconomic-benefits.membership-create
                            :in-modal="true"
                            @insured-created="insuredCreated($event.detail.message)"
                            @close-membership-modal="closeCreateModal"
                            :key="'membership-create-modal-'.$createModalInstance" />
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

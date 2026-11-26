<div class="bg-white p-4 lg:p-5">
    <section aria-label="Listado de familiares">
        <div class="mb-4 flex justify-end">
            <button type="button" wire:click="openCreateModal"
                class="inline-flex items-center gap-2 rounded-lg border border-[#E7DFD9] bg-white px-6 py-2.5 text-xs font-medium uppercase text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                Nuevo familiar
            </button>
        </div>
        <div class="mb-5 rounded-xl border border-[#E7DFD9] bg-[#F7F3EC] p-4 sm:p-5"
            aria-labelledby="beneficiary-search-heading">
            <div class="mb-3 flex items-center gap-3">
                <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#651F34] shadow-sm">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 1 0 3.46 9.78l3.63 3.63a.75.75 0 1 0 1.06-1.06l-3.63-3.63A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <h2 id="beneficiary-search-heading" class="text-sm font-semibold text-[#651F34]">
                        Buscar familiares
                    </h2>
                    <p class="mt-0.5 text-xs text-slate-600">
                        Filtra por folio, nombre, apellidos, RFC o CURP.
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <label for="beneficiary-search" class="sr-only">Buscar familiares</label>
                <input wire:model.live="search" id="beneficiary-search" type="search"
                    class="block w-full min-w-0 flex-1 rounded-lg border border-[#D9CBC5] bg-white px-3 py-2.5 text-base text-surface outline-none transition placeholder:text-neutral-500 focus:border-[#651F34] focus:ring-2 focus:ring-[#651F34]/20 sm:max-w-2xl"
                    placeholder="Escribe un criterio de búsqueda"
                    aria-label="Buscar familiares por folio, nombre, apellidos, RFC o CURP" />
                <div class="flex shrink-0 items-center gap-2 text-sm text-slate-700 sm:ml-auto">
                    <label for="beneficiary-rows" class="font-medium">Mostrar</label>
                    <select wire:model.live="numberRows" id="beneficiary-rows"
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
                        <th scope="col" class="whitespace-nowrap px-4 py-3">CURP</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Estatus</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-white/10">
                    @forelse ($lista as $item)
                        @php
                            $nombreFamiliar = collect([$item->last_name_1, $item->last_name_2, $item->name])
                                ->filter(fn ($parte) => filled($parte))
                                ->implode(' ');
                            $estatus = trim($item->affiliate_status ?? '');
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
                            <td class="max-w-xs break-words px-4 py-3">{{ $nombreFamiliar ?: 'Nombre no disponible' }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $item->curp }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold shadow-sm {{ $estiloEstatus['badge'] }}">
                                    <span class="h-2 w-2 rounded-full ring-2 ring-white {{ $estiloEstatus['dot'] }}"
                                        aria-hidden="true"></span>
                                    {{ $estatus ?: 'Sin estatus de afiliación' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <div class="flex min-w-max items-center justify-center gap-2">
                                    <button type="button" wire:click="openEditModal({{ $item->id }})"
                                        @disabled($item->affiliate_status !== 'Activo' || $item->status !== 'active')
                                        title="{{ $item->affiliate_status === 'Activo' && $item->status === 'active' ? 'Editar familiar' : 'Solo se editan familiares activos' }}"
                                        aria-label="{{ $item->affiliate_status === 'Activo' && $item->status === 'active' ? 'Editar familiar '.$nombreFamiliar : 'No editable: familiar inactivo' }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1 disabled:cursor-not-allowed disabled:opacity-40">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        <span class="sr-only">Editar</span>
                                    </button>
                                    <button type="button" wire:click="openPhotoCapture({{ $item->id }})"
                                        title="Capturar fotografía"
                                        aria-label="Capturar fotografía de {{ $nombreFamiliar ?: 'familiar' }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 7.5 8.1 5.7a1.5 1.5 0 0 1 1.2-.6h5.4a1.5 1.5 0 0 1 1.2.6l1.35 1.8h1.5A2.25 2.25 0 0 1 21 9.75v8.1a2.25 2.25 0 0 1-2.25 2.25h-13.5A2.25 2.25 0 0 1 3 17.85v-8.1A2.25 2.25 0 0 1 5.25 7.5h1.5Z" />
                                            <circle cx="12" cy="13.5" r="3.25" />
                                        </svg>
                                        <span class="sr-only">Capturar fotografía</span>
                                    </button>
                                    <button type="button" wire:click="openCredentials({{ $item->id }})"
                                        title="Historial de credenciales"
                                        aria-label="Ver historial de credenciales de {{ $nombreFamiliar ?: 'familiar' }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <rect x="3.5" y="4.5" width="17" height="15" rx="2" />
                                            <circle cx="8.5" cy="10" r="2" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.75 16a2.75 2.75 0 0 1 5.5 0m2.25-6.5h4m-4 3h4m-4 3h2.5" />
                                        </svg>
                                        <span class="sr-only">Historial de credenciales</span>
                                    </button>
                                    <a href="{{ route('beneficiaries.show', $item->id) }}"
                                        title="Abrir expediente electrónico"
                                        aria-label="Abrir expediente electrónico de {{ $nombreFamiliar ?: 'familiar' }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.25 8V6.75A1.75 1.75 0 0 1 5 5h5l2 2h7A1.75 1.75 0 0 1 20.75 8.75V10" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.25 9.75h17.5v8.5A1.75 1.75 0 0 1 19 20H5a1.75 1.75 0 0 1-1.75-1.75z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7 13.25h10m-10 3h6" />
                                        </svg>
                                        <span class="sr-only">Abrir expediente</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No se encontraron familiares que coincidan con la búsqueda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $lista->links('livewire.socioeconomic-benefits.pagination') }}
        <livewire:socioeconomic-benefits.beneficiary-create-form />
        <livewire:socioeconomic-benefits.beneficiary-edit-form />
        <livewire:socioeconomic-benefits.beneficiary-photo-capture />
        <livewire:socioeconomic-benefits.beneficiary-credentials-modal />

        @if ($successMessage)
            <div class="fixed inset-0 z-[120] flex items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm"
                wire:click.self="dismissSuccessModal"
                x-on:keydown.escape.window="$wire.dismissSuccessModal()"
                role="dialog" aria-modal="true" aria-labelledby="beneficiary-success-title"
                aria-describedby="beneficiary-success-message">
                <section class="w-full max-w-md overflow-hidden rounded-2xl border border-[#E7DFD9] bg-white shadow-2xl"
                    wire:click.stop>
                    <div class="h-2 bg-[#651F34]"></div>
                    <div class="p-6 text-center sm:p-8">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" class="h-9 w-9" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12.5 4.5 4.5L19 7.5" />
                            </svg>
                        </div>
                        <p class="mt-5 text-xs font-semibold uppercase tracking-[0.16em] text-[#8A6670]">
                            Prestaciones Socioeconómicas
                        </p>
                        <h2 id="beneficiary-success-title" class="mt-2 text-2xl font-bold text-[#651F34]">
                            {{ $successTitle }}
                        </h2>
                        <p id="beneficiary-success-message" class="mt-3 text-sm leading-6 text-slate-600">
                            {{ $successMessage }}
                        </p>
                        <button type="button" wire:click="dismissSuccessModal"
                            class="mt-7 inline-flex w-full items-center justify-center rounded-lg bg-[#651F34] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2 sm:w-auto sm:min-w-36">
                            Continuar
                        </button>
                    </div>
                </section>
            </div>
        @endif
    </section>
</div>

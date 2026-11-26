<div class="bg-white p-4 lg:p-5">
    <section aria-label="Listado de pensionados">
        <div class="mb-5 rounded-xl border border-[#E7DFD9] bg-[#F7F3EC] p-4 sm:p-5"
            aria-labelledby="pensioner-search-heading">
            <div class="mb-3 flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#651F34] shadow-sm">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 1 0 3.46 9.78l3.63 3.63a.75.75 0 1 0 1.06-1.06l-3.63-3.63A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <h2 id="pensioner-search-heading" class="text-sm font-semibold text-[#651F34]">
                        Buscar pensionados
                    </h2>
                    <p class="mt-0.5 text-xs text-slate-600">
                        Filtra por número de pensión, nombre, RFC, CURP o tipo de pensión.
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <label for="pensioner-search" class="sr-only">Buscar pensionados</label>
                <input wire:model.live="search" id="pensioner-search" type="search"
                    class="block w-full min-w-0 flex-1 rounded-lg border border-[#D9CBC5] bg-white px-3 py-2.5 text-base text-surface outline-none transition placeholder:text-neutral-500 focus:border-[#651F34] focus:ring-2 focus:ring-[#651F34]/20 sm:max-w-2xl"
                    placeholder="Escribe un criterio de búsqueda"
                    aria-label="Buscar pensionados por número de pensión, nombre, RFC, CURP o tipo de pensión" />
                <div class="flex shrink-0 items-center gap-2 text-sm text-slate-700 sm:ml-auto">
                    <label for="pensioner-rows" class="font-medium">Mostrar</label>
                    <select wire:model.live="numberRows" id="pensioner-rows"
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
                <thead
                    class="border-b border-neutral-200 bg-neutral-50 font-medium dark:border-white/10 dark:bg-neutral-800">
                    <tr>
                        <th scope="col" class="whitespace-nowrap px-4 py-3">#</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3">Número de pensión</th>
                        <th scope="col" class="px-4 py-3">Nombre</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3">Tipo de pensión</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3">RFC</th>
                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Estatus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-white/10">
                    @forelse ($lista as $item)
                        @php
                            $nombrePensionado = collect([$item->last_name_1, $item->last_name_2, $item->name])
                                ->filter(fn ($parte) => filled($parte))
                                ->implode(' ');
                            $estatus = trim($item->status ?? '');
                            $estiloEstatus = match (mb_strtolower($estatus)) {
                                'activo' => [
                                    'badge' => 'border-green-200 bg-green-50 text-green-800',
                                    'dot' => 'bg-green-500',
                                ],
                                'baja' => [
                                    'badge' => 'border-red-200 bg-red-50 text-red-800',
                                    'dot' => 'bg-red-500',
                                ],
                                default => [
                                    'badge' => 'border-slate-200 bg-slate-50 text-slate-700',
                                    'dot' => 'bg-slate-400',
                                ],
                            };
                        @endphp
                        <tr wire:key="pensioner-{{ $item->id }}"
                            class="hover:bg-neutral-50 dark:hover:bg-neutral-800/60">
                            <td class="whitespace-nowrap px-4 py-3 font-medium">{{ $item->id }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $item->noi_number ?: 'No disponible' }}</td>
                            <td class="max-w-xs break-words px-4 py-3">
                                {{ $nombrePensionado ?: 'Nombre no disponible' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3">
                                {{ $item->pensionType?->name ?: 'No especificado' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $item->rfc ?: '—' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                <span
                                    class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold shadow-sm {{ $estiloEstatus['badge'] }}">
                                    <span
                                        class="h-2 w-2 rounded-full ring-2 ring-white {{ $estiloEstatus['dot'] }}"
                                        aria-hidden="true"></span>
                                    {{ $estatus ?: 'Sin estatus' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No se encontraron pensionados que coincidan con la búsqueda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $lista->links('livewire.socioeconomic-benefits.pagination') }}
    </section>
</div>

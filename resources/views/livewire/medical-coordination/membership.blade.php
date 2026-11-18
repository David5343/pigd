<div>
    <div class="p-4 lg:p-5 bg-white border-b border-gray-200">
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-4 lg:-mx-5">
                <div class="inline-block min-w-full py-2 sm:px-4 lg:px-5">
                    <div class="relative">
                        <input wire:model.live="search" type="search"
                            class="relative m-0 block w-full rounded border border-solid border-neutral-200 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:border-primary focus:shadow-inset focus:outline-none motion-reduce:transition-none dark:border-white/10 dark:text-white dark:placeholder:text-neutral-200 dark:autofill:shadow-autofill dark:focus:border-primary"
                            placeholder="Buscar por folio, número de empleado, nombre, RFC o CURP" aria-label="Buscar titulares"
                            id="exampleFormControlInput4" />
                    </div>
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead class="border-b border-neutral-200 font-medium dark:border-white/10">
                                <tr>
                                    <th scope="col" class="px-6 py-4">#</th>
                                    <th scope="col" class="px-6 py-4">Folio</th>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">RFC</th>
                                    <th scope="col" class="px-6 py-4 text-center">Estatus</th>
                                    <th scope="col" class="px-6 py-4 text-center">Expediente electrónico</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lista as $item)
                                    <tr class="border-b border-neutral-200 dark:border-white/10">
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $item->id }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $item->file_number }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ $item->last_name_1 . ' ' . $item->last_name_2 . ' ' . $item->name }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ $item->rfc }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-center">
                                            @php
                                                $estatus = trim($item->affiliationStatus?->name ?? '');
                                                $estiloEstatus = match (mb_strtolower($estatus)) {
                                                    'preafiliado' => [
                                                        'badge' => 'border-amber-200 bg-amber-50 text-amber-800',
                                                        'dot' => 'bg-amber-500',
                                                    ],
                                                    'activo' => [
                                                        'badge' => 'border-green-200 bg-green-50 text-green-800',
                                                        'dot' => 'bg-green-500',
                                                    ],
                                                    'bloqueado' => [
                                                        'badge' => 'border-gray-200 bg-gray-100 text-gray-700',
                                                        'dot' => 'bg-gray-500',
                                                    ],
                                                    'baja' => [
                                                        'badge' => 'border-red-200 bg-red-50 text-red-800',
                                                        'dot' => 'bg-red-500',
                                                    ],
                                                    'baja por aplicar' => [
                                                        'badge' => 'border-orange-200 bg-orange-50 text-orange-800',
                                                        'dot' => 'bg-orange-500',
                                                    ],
                                                    default => [
                                                        'badge' => 'border-slate-200 bg-slate-50 text-slate-700',
                                                        'dot' => 'bg-slate-400',
                                                    ],
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold shadow-sm {{ $estiloEstatus['badge'] }}">
                                                <span class="h-2 w-2 rounded-full ring-2 ring-white {{ $estiloEstatus['dot'] }}"
                                                    aria-hidden="true"></span>
                                                {{ $estatus ?: 'Sin estatus de afiliación' }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-center">
                                            <a href="{{ route('membership_medical.show', $item->id) }}"
                                                title="Abrir expediente electrónico"
                                                aria-label="Abrir expediente electrónico de {{ trim($item->last_name_1 . ' ' . $item->last_name_2 . ' ' . $item->name) }}"
                                                class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="h-5 w-5"
                                                    aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.25 8V6.75A1.75 1.75 0 0 1 5 5h5l2 2h7A1.75 1.75 0 0 1 20.75 8.75V10" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.25 9.75h17.5v8.5A1.75 1.75 0 0 1 19 20H5a1.75 1.75 0 0 1-1.75-1.75z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M7 13.25h10m-10 3h6" />
                                                </svg>
                                                <span class="sr-only">Abrir expediente</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            No se encontraron titulares.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $lista->links('livewire.medical-coordination.pagination') }}
            </div>
        </div>
    </div>
</div>

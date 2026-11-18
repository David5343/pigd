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
                                    <th scope="col" class="px-6 py-4">Estatus</th>
                                    <th scope="col" class="px-6 py-4">Ver</th>
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
                                        <td class="whitespace-nowrap px-6 py-4">
                                            {{ $item->affiliationStatus?->name ?? 'Sin estatus de afiliación' }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <a href="{{ url('medical_coordination/membership/' . $item->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                                                </svg>
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
                {{ $lista->links() }}
            </div>
        </div>
    </div>
</div>

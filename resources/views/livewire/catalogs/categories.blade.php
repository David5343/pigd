<div>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        <h1 class="mt-2 text-2xl font-medium text-gray-900">
            PIGD
        </h1>
        <div class="text-right">
            <a href="{{ route('categories.create') }}"
                class="inline-flex items-center gap-2 rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal bg-neutral-100 text-neutral-700 transition duration-150 ease-in-out hover:bg-blue-300 hover:text-blue-600 focus:text-blue-600 focus:outline-none focus:ring-0 active:text-primary-700 dark:hover:bg-neutral-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
                NUEVA CATEGORIA
            </a>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="relative">
                        <input wire:model.live="search" type="search"
                            class="relative m-0 block w-full rounded border border-solid border-neutral-200 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:border-primary focus:shadow-inset focus:outline-none motion-reduce:transition-none dark:border-white/10 dark:text-white dark:placeholder:text-neutral-200 dark:autofill:shadow-autofill dark:focus:border-primary"
                            placeholder="Busca por Nombre" aria-label="Search" id="exampleFormControlInput4" />
                    </div>
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead class="border-b border-neutral-200 font-medium dark:border-white/10">
                                <tr>
                                    <th scope="col" class="px-6 py-4">#</th>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Puestos autorizados</th>
                                    <th scope="col" class="px-6 py-4">Puestos cubiertos</th>
                                    <th scope="col" class="px-6 py-4">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($lista->count())
                                    @foreach ($lista as $item)
                                        <tr class="border-b border-neutral-200 dark:border-white/10">
                                            <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $item->id }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                {{ $item->name }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                {{ $item->authorized_position }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                {{ $item->covered_position }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                <a
                                                    href="{{ url('human_resources/catalogs/categories/' . $item->id . '/edit') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="flex justify-between items-center mt-4">
                            {{-- Texto del resumen --}}
                            <p class="text-sm text-gray-600">
                                Mostrando de {{ $lista->firstItem() }} a {{ $lista->lastItem() }} de
                                {{ $lista->total() }} resultados
                            </p>

                            {{-- Botones de paginación --}}
                            <div class="flex space-x-2">
                                {{-- Botón anterior --}}
                                @if ($lista->onFirstPage())
                                    <span
                                        class="px-4 py-2 text-sm text-gray-400 bg-gray-100 rounded cursor-not-allowed">Anterior</span>
                                @else
                                    <button wire:click="previousPage"
                                        class="px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded">
                                        Anterior
                                    </button>
                                @endif

                                {{-- Botón siguiente --}}
                                @if ($lista->hasMorePages())
                                    <button wire:click="nextPage"
                                        class="px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded">
                                        Siguiente
                                    </button>
                                @else
                                    <span
                                        class="px-4 py-2 text-sm text-gray-400 bg-gray-100 rounded cursor-not-allowed">Siguiente</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-2 w-full md:w-auto">
            <span class="text-sm text-gray-700">Listar por</span>
            <select wire:model.live="numberRows"
                class="border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200 md:w-1/12">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
            <span class="text-sm text-gray-700">filas</span>
        </div>
    </div>
    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8"></div>
</div>

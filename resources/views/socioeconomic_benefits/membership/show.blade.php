<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prestaciones SocioEconómicas/Afiliación') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class=" text-center">
                    <p>
                    <h3 class="mb-2 mt-0 text-3xl font-medium leading-tight text-primary">FOLIO AFILIACIÓN:</h3>
                    </p>
                    <p>
                    <h5 class="mb-2 mt-0 text-xl font-medium leading-tight text-primary">{{ $titular->file_number }}</h5>
                    </p>
                </div>
                <div class="flex justify-center mt-5">
                    <figure class="mb-4 inline-block max-w-sm">
                        <img src="{{ empty($titular->photo) ? asset('images/icono_no_imagen.png') : url($titular->photo) }}"
                            class="mb-4 h-auto max-w-full max-h-full rounded-lg align-middle leading-none shadow-lg"
                            alt="Hollywood Sign on The Hill" />
                        <figcaption class="text-center text-sm text-neutral-600 dark:text-neutral-400">
                            <p><span>ESTATUS DE AFILIACIÓN</span></p>
                            @php
                                $status = $titular->affiliate_status;

                                $statusColors = match ($status) {
                                    'Activo' => 'bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-400',
                                    'Preafiliado'
                                        => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-950 dark:text-yellow-400',
                                    'Baja',
                                    'Baja por Aplicar'
                                        => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-400',
                                    default
                                        => 'bg-gray-100 text-gray-700 dark:bg-gray-950 dark:text-gray-400', // Color por defecto si no coincide
                                };
                            @endphp

                            <p>
                                <span class="inline-block whitespace-nowrap rounded-md px-2 py-1 {{ $statusColors }}">
                                    {{ $titular->affiliate_status }}
                                </span>
                            </p>


                        </figcaption>
                    </figure>
                </div>
                <div id="accordionExample">
                    <!-- Sección 1 -->
                    <div x-data="{ open: false }"
                        class="rounded-t-lg border border-neutral-200 bg-white dark:border-neutral-600 dark:bg-body-dark">
                        <h2 class="mb-0" id="headingOne">
                            <button @click="open = !open"
                                class="group relative flex w-full items-center rounded-t-lg border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition hover:z-[2] focus:z-[3] focus:outline-none dark:bg-body-dark dark:text-white"
                                type="button">
                                DATOS GENERALES
                                <span
                                    class="-me-1 ms-auto h-5 w-5 shrink-0 transition-transform duration-200 ease-in-out"
                                    :class="open ? 'rotate-180' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </button>
                        </h2>
                        <div x-show="open" x-collapse class="px-5 py-4 border-t bg-white dark:bg-gray-800">
                            <p><strong>FOLIO AFILIACIÓN:</strong> {{ $titular->file_number }}</p>
                            <p><strong>DEPENDENCIA:</strong> {{ $titular->subdependency->dependency->name }}</p>
                            <p><strong>SUBDEPENDENCIA:</strong> {{ $titular->subdependency->name }}</p>
                            <p><strong>CATEGORÍA:</strong> {{ $titular->rank->name }}</p>
                            <p><strong>FECHA DE INGRESO:</strong> {{ $titular->start_date }}</p>
                            <p><strong>LUGAR DE TRABAJO:</strong>
                                @if (($titular->work_place == '') | ($titular->work_place == null))
                                    NO DISPONIBLE
                                @else
                                    {{ $titular->work_place }}
                                @endif
                            </p>
                            <p><strong>MOTIVO DE REGISTRO:</strong>
                                @if (($titular->register_motive == '') | ($titular->register_motive == null))
                                    NO DISPONIBLE
                                @else
                                    {{ $titular->register_motive }}
                                @endif
                            </p>
                            <p><strong>OBSERVACIONES:</strong>
                                @if (($titular->observations == '') | ($titular->observations == null))
                                    NO DISPONIBLE
                                @else
                                    {{ $titular->observations }}
                                @endif
                            </p>
                            <p><strong>FECHA DE BAJA (DEPENDENCIA):</strong>
                                @if (($titular->inactive_date_dependency == '') | ($titular->inactive_date_dependency == null))
                                    NO DISPONIBLE
                                @else
                                    {{ $titular->inactive_date_dependency }}
                                @endif
                            </p>
                            <p><strong>FECHA DE BAJA DE SISTEMA:</strong>
                                @if (($titular->inactive_date == '') | ($titular->inactive_date == null))
                                    NO DISPONIBLE
                                @else
                                    {{ $titular->inactive_date }}
                                @endif
                            </p>
                            <p><strong>MOTIVO DE BAJA:</strong>
                                @if (($titular->inactive_motive == '') | ($titular->inactive_motive == null))
                                    NO DISPONIBLE
                                @else
                                    {{ $titular->inactive_motive }}
                                @endif
                            </p>
                            <p><strong>FECHA DE REINGRESO:</strong>
                                @if (($titular->reentry_date == '') | ($titular->reentry_date == null))
                                    NO DISPONIBLE
                                @else
                                    {{ $titular->reentry_date }}
                                @endif
                            </p>
                            <p><strong>ESTATUS DE REGISTRO:</strong> {{ $titular->status }}</p>
                        </div>
                    </div>

                    <!-- Sección 2 -->
                    <div x-data="{ open: false }"
                        class="border border-t-0 border-neutral-200 bg-white dark:border-neutral-600 dark:bg-body-dark">
                        <h2 class="mb-0" id="headingTwo">
                            <button @click="open = !open"
                                class="group relative flex w-full items-center border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition hover:z-[2] focus:z-[3] focus:outline-none dark:bg-body-dark dark:text-white"
                                type="button">
                                DATOS PERSONALES
                                <span
                                    class="-me-1 ms-auto h-5 w-5 shrink-0 transition-transform duration-200 ease-in-out"
                                    :class="open ? 'rotate-180' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </button>
                        </h2>
                        <div x-show="open" x-collapse class="px-5 py-4 border-t bg-white dark:bg-gray-800">
                            <strong>Este es el contenido de la sección 2.</strong> Agrega aquí más información.
                        </div>
                    </div>

                    <!-- Sección 3 -->
                    <div x-data="{ open: false }"
                        class="rounded-b-lg border border-t-0 border-neutral-200 bg-white dark:border-neutral-600 dark:bg-body-dark">
                        <h2 class="mb-0" id="headingThree">
                            <button @click="open = !open"
                                class="group relative flex w-full items-center border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition hover:z-[2] focus:z-[3] focus:outline-none dark:bg-body-dark dark:text-white"
                                type="button">
                                Accordion Item #3
                                <span
                                    class="-me-1 ms-auto h-5 w-5 shrink-0 transition-transform duration-200 ease-in-out"
                                    :class="open ? 'rotate-180' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </span>
                            </button>
                        </h2>
                        <div x-show="open" x-collapse class="px-5 py-4 border-t bg-white dark:bg-gray-800">
                            <strong>Este es el contenido de la sección 3.</strong> Última sección del acordeón.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

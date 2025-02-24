<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prestaciones SocioEconómicas/Afiliación/Familiares') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class=" text-center">
                    <p>
                    <h3 class="mb-2 mt-0 text-3xl font-medium leading-tight text-primary">FICHA TÉCNICA</h3>
                    </p>
                    <p>
                    <h4 class="mb-2 mt-0 text-2xl font-medium leading-tight text-primary">FOLIO AFILIACIÓN:</h4>
                    </p>
                    <p>
                    <h5 class="mb-2 mt-0 text-xl font-medium leading-tight text-primary">{{ $familiar->file_number }}
                    </h5>
                    </p>
                </div>
                <div class="flex justify-center mt-5">
                    <figure class="mb-4 inline-block max-w-sm">
                        <img src="{{ empty($familiar->photo) ? asset('images/icono_no_imagen.png') : url($familiar->photo) }}"
                            class="mb-4 h-auto max-w-full max-h-full rounded-lg align-middle leading-none shadow-lg"
                            alt="Hollywood Sign on The Hill" />
                        <figcaption class="text-center text-sm text-neutral-600 dark:text-neutral-400">
                            <p><span>ESTATUS DE AFILIACIÓN</span></p>
                            @php
                                $status = $familiar->affiliate_status;

                                $statusColors = match ($status) {
                                    'Activo' => 'bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-400',
                                    'Baja',
                                    'Baja por Aplicar'
                                        => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-400',
                                    default
                                        => 'bg-gray-100 text-gray-700 dark:bg-gray-950 dark:text-gray-400', // Color por defecto si no coincide
                                };
                            @endphp

                            <p>
                                <span class="inline-block whitespace-nowrap rounded-md px-2 py-1 {{ $statusColors }}">
                                    {{ $familiar->affiliate_status }}
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
                            <!-- Tabla -->
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
                                    <tbody>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>FOLIO AFILIACIÓN:</strong> {{ $familiar->file_number }}</p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>FECHA DE INGRESO:</strong> {{ $familiar->start_date }}</p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>OBSERVACIONES:</strong>
                                                    @if (($familiar->observations == '') | ($familiar->observations == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $familiar->observations }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>FECHA DE BAJA DE SISTEMA:</strong>
                                                    @if (($familiar->inactive_date == '') | ($familiar->inactive_date == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $familiar->inactive_date }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>MOTIVO DE BAJA:</strong>
                                                    @if (($familiar->inactive_motive == '') | ($familiar->inactive_motive == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $familiar->inactive_motive }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>FECHA DE REINGRESO:</strong>
                                                    @if (($familiar->reentry_date == '') | ($familiar->reentry_date == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $familiar->reentry_date }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>ESTATUS DE REGISTRO:</strong> {{ $familiar->status }}</p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                            <!-- Tabla -->
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
                                    <tbody>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>NOMBRE:</strong>
                                                    {{ $familiar->last_name_1 . ' ' . $familiar->last_name_2 . ' ' . $familiar->name }}
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>FECHA DE NACIMIENTO:</strong>
                                                    @if (($familiar->birthday == '') | ($familiar->birthday == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $familiar->birthday }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>CURP:</strong>
                                                    @if (($familiar->curp == '') | ($familiar->curp == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $familiar->curp }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>SEXO:</strong> {{ $familiar->sex }}</p>
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>PARENTESCO:</strong> {{ $familiar->relationship }}</p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>DIVERSAS CAPACIDADES:</strong>
                                                    @if (($familiar->curp == '') | ($familiar->curp == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $familiar->curp }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>DIRECCIÓN:</strong>
                                                    @if (($familiar->address == '') | ($familiar->address == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $familiar->address }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 3 -->
                    <div x-data="{ open: false }"
                        class="rounded-b-lg border border-t-0 border-neutral-200 bg-white dark:border-neutral-600 dark:bg-body-dark">
                        <h2 class="mb-0" id="headingThree">
                            <button @click="open = !open"
                                class="group relative flex w-full items-center border-0 bg-white px-5 py-4 text-left text-base text-neutral-800 transition hover:z-[2] focus:z-[3] focus:outline-none dark:bg-body-dark dark:text-white"
                                type="button">
                                FAMILIAR DE:
                                {{ $familiar->insured->last_name_1 . ' ' . $familiar->insured->last_name_2 . ' ' . $familiar->insured->name . '-(' . $familiar->insured->file_number . ')' }}
                                <a class="mx-3"
                                    href="{{ url('socioeconomic_benefits/membership/' . $familiar->insured->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>

                                </a>
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
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table
                                            class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                                            <tbody>
                                                <tr
                                                    class="border-b border-neutral-200 bg-black/[0.02] dark:border-white/10">
                                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                        <p><strong>FOLIO AFILIACIÓN:</strong>
                                                            @if (($familiar->insured->file_number == '') | ($familiar->insured->file_number == null))
                                                                NO DISPONIBLE
                                                            @else
                                                                {{ $familiar->insured->file_number }}
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                        <p><strong>FECHA DE INGRESO:</strong>
                                                            @if (($familiar->insured->start_date == '') | ($familiar->insured->start_date == null))
                                                                NO DISPONIBLE
                                                            @else
                                                                {{ $familiar->insured->start_date }}
                                                            @endif
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-b border-neutral-200 bg-white dark:border-white/10 dark:bg-body-dark">
                                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                        <p><strong>NOMBRE:</strong>
                                                            {{ $familiar->insured->last_name_1 . ' ' . $familiar->insured->last_name_2 . ' ' . $familiar->insured->name }}
                                                        </p>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                        <p><strong>FECHA DE NACIMIENTO:</strong>
                                                            @if (($familiar->insured->birthday == '') | ($familiar->insured->birthday == null))
                                                                NO DISPONIBLE
                                                            @else
                                                                {{ $familiar->insured->birthday }}
                                                            @endif
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-b border-neutral-200 bg-black/[0.02] dark:border-white/10">
                                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                        <p><strong>RFC:</strong>
                                                            @if (($familiar->insured->rfc == '') | ($familiar->insured->rfc == null))
                                                                NO DISPONIBLE
                                                            @else
                                                                {{ $familiar->insured->rfc }}
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                        <p><strong>CURP:</strong>
                                                            @if (($familiar->insured->curp == '') | ($familiar->insured->curp == null))
                                                                NO DISPONIBLE
                                                            @else
                                                                {{ $familiar->insured->curp }}
                                                            @endif
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-b border-neutral-200 bg-white dark:border-white/10 dark:bg-body-dark">
                                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                        <p><strong>DEPENDENCIA:</strong>
                                                            @if (
                                                                ($familiar->insured->subdependency->dependency->name == '') |
                                                                    ($familiar->insured->subdependency->dependency->name == null))
                                                                NO DISPONIBLE
                                                            @else
                                                                {{ $familiar->insured->subdependency->dependency->name }}
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                        <p><strong>ESTATUS DE AFILIACIÓ:</strong>
                                                            @if (($familiar->insured->affiliate_status == '') | ($familiar->insured->affiliate_status == null))
                                                                NO DISPONIBLE
                                                            @else
                                                                {{ $familiar->insured->affiliate_status }}
                                                            @endif
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

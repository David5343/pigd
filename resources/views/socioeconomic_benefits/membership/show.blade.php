<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prestaciones SocioEconómicas/Afiliación/Titulares') }}
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
                    <h5 class="mb-2 mt-0 text-xl font-medium leading-tight text-primary">{{ $titular->file_number }}</h5>
                    </p>
                </div>
                <div class="flex justify-center mt-5">
                    <figure class="mb-4 inline-block max-w-sm">
                        <img src="{{ empty($titular->photo) ? asset('images/icono_no_imagen.png') : 'http:'.$titular->photo }}"
                        class="mb-4 h-auto max-w-full max-h-full rounded-lg align-middle leading-none shadow-lg"
                            alt="Hollywood Sign on The Hill">

                        {{-- <img src="{{ empty($titular->photo) ? asset('images/icono_no_imagen.png') : url($titular->photo) }}"
                            class="mb-4 h-auto max-w-full max-h-full rounded-lg align-middle leading-none shadow-lg"
                            alt="Hollywood Sign on The Hill" /> --}}
                        <figcaption class="text-center text-sm text-neutral-600 dark:text-neutral-400">
                            <p><span>ESTATUS DE AFILIACIÓN</span></p>
                            @php
                                $status = $titular->affiliationStatus->name;

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
                                    {{ $titular->affiliationStatus->name }}
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
                                                <p><strong>FOLIO AFILIACIÓN:</strong> {{ $titular->file_number }}</p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>DEPENDENCIA:</strong>
                                                    {{ $titular->subdependency->dependency->name }}</p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>SUBDEPENDENCIA:</strong> {{ $titular->subdependency->name }}
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>CATEGORÍA:</strong> {{ $titular->rank->name }}</p>
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>FECHA DE INGRESO:</strong> {{ $titular->start_date }}</p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>LUGAR DE TRABAJO:</strong>
                                                    @if (($titular->workplaceCounty == '') | ($titular->workplaceCounty == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->workplaceCounty->name }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>MOTIVO DE REGISTRO:</strong>
                                                    @if (($titular->register_motive == '') | ($titular->register_motive == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->register_motive }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>OBSERVACIONES:</strong>
                                                    @if (($titular->observations == '') | ($titular->observations == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->observations }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>FECHA DE BAJA (DEPENDENCIA):</strong>
                                                    @if (($titular->inactive_date_dependency == '') | ($titular->inactive_date_dependency == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->inactive_date_dependency }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>FECHA DE BAJA DE SISTEMA:</strong>
                                                    @if (($titular->inactive_date == '') | ($titular->inactive_date == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->inactive_date }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>MOTIVO DE BAJA:</strong>
                                                    @if (($titular->inactive_motive == '') | ($titular->inactive_motive == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->inactive_motive }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>FECHA DE REINGRESO:</strong>
                                                    @if (($titular->reentry_date == '') | ($titular->reentry_date == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->reentry_date }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>ESTATUS DE REGISTRO:</strong> {{ $titular->status }}</p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong></strong>
                                                </p>
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
                                                    {{ $titular->last_name_1 . ' ' . $titular->last_name_2 . ' ' . $titular->name }}
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>FECHA DE NACIMIENTO:</strong>
                                                    @if (($titular->birthday == '') | ($titular->birthday == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->birthday }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>LUGAR DE NACIMIENTO:</strong>
                                                    @if (($titular->birthplaceCounty == '') | ($titular->birthplaceCounty == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->birthplaceCounty->name }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>SEXO:</strong> {{ $titular->sex }}</p>
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>ESTADO CIVIL:</strong>
                                                    @if (($titular->marital_status == '') | ($titular->marital_status == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->marital_status }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>RFC:</strong>
                                                    @if (($titular->rfc == '') | ($titular->rfc == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->rfc }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>CURP:</strong>
                                                    @if (($titular->curp == '') | ($titular->curp == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->curp }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>TELEFONO:</strong>
                                                    @if (($titular->phone == '') | ($titular->phone == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->phone }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>CORREO ELECTÓNICO:</strong>
                                                    @if (($titular->email == '') | ($titular->email == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->email }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>ESTADO:</strong>
                                                @if (!$titular->county?->state)
                                                    NO DISPONIBLE
                                                @else
                                                    {{ $titular->county->state->name }}
                                                @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>MUNICIPIO:</strong>
                                                    @if (($titular->county == '') | ($titular->county == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->county->name }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>COLONIA:</strong>
                                                    @if (($titular->neighborhood == '') | ($titular->neighborhood == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->neighborhood }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>TIPO DE VIALIDAD:</strong>
                                                    @if (($titular->roadway_type == '') | ($titular->roadway_type == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->roadway_type }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>NOMBRE DE LA VIALIDAD (CALLE):</strong>
                                                    @if (($titular->street == '') | ($titular->street == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->street }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>NO. DE EXTERIOR:</strong>
                                                    @if (($titular->outdoor_number == '') | ($titular->outdoor_number == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->outdoor_number }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>NO. DE INTERIOR:</strong>
                                                    @if (($titular->interior_number == '') | ($titular->interior_number == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->interior_number }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>CP:</strong>
                                                    @if (($titular->cp == '') | ($titular->cp == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->cp }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong>LOCALIDAD:</strong>
                                                    @if (($titular->locality == '') | ($titular->locality == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->locality }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100 dark:bg-gray-700">
                                            <td class="border border-gray-300 px-4 py-2">
                                                <p><strong>TIPO DE SANGRE:</strong>
                                                    @if (($titular->blood_type == '') | ($titular->blood_type == null))
                                                        NO DISPONIBLE
                                                    @else
                                                        {{ $titular->blood_type }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 hidden md:table-cell">
                                                <p><strong></strong>
                                                </p>
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
                                FAMILIARES
                                @php
                                    $count = $titular->beneficiaries->count();
                                @endphp
                                {{ '(' . $count . ')' }}
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
                            @if ($count > 0)
                                @foreach ($titular->beneficiaries as $fam)
                                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                            <div class="overflow-hidden">
                                                <table
                                                    class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                                                    <thead
                                                        class="border-b border-neutral-200 bg-white font-medium dark:border-white/10 dark:bg-body-dark">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-12">
                                                                PARENTESCO:{{ $fam->relationship }}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            class="border-b border-neutral-200 bg-black/[0.02] dark:border-white/10">
                                                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                                <p><strong>FOLIO AFILIACIÓN:</strong>
                                                                    @if (($fam->file_number == '') | ($fam->file_number == null))
                                                                        NO DISPONIBLE
                                                                    @else
                                                                        {{ $fam->file_number }}
                                                                    @endif
                                                                </p>
                                                            </td>
                                                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                                <p><strong>FECHA DE INGRESO:</strong>
                                                                    @if (($fam->start_date == '') | ($fam->start_date == null))
                                                                        NO DISPONIBLE
                                                                    @else
                                                                        {{ $fam->start_date }}
                                                                    @endif
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr
                                                            class="border-b border-neutral-200 bg-white dark:border-white/10 dark:bg-body-dark">
                                                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                                <p><strong>NOMBRE:</strong>
                                                                    {{ $fam->last_name_1 . ' ' . $fam->last_name_2 . ' ' . $fam->name }}
                                                                </p>
                                                            </td>
                                                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                                <p><strong>FECHA DE NACIMIENTO:</strong>
                                                                    @if (($fam->birthday == '') | ($fam->birthday == null))
                                                                        NO DISPONIBLE
                                                                    @else
                                                                        {{ $fam->birthday }}
                                                                    @endif
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr
                                                            class="border-b border-neutral-200 bg-black/[0.02] dark:border-white/10">
                                                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                                <p><strong>CURP:</strong>
                                                                    @if (($fam->curp == '') | ($fam->curp == null))
                                                                        NO DISPONIBLE
                                                                    @else
                                                                        {{ $fam->curp }}
                                                                    @endif
                                                                </p>
                                                            </td>
                                                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                                <p><strong>ESTATUS DE AFILIACIÓ:</strong>
                                                                    @if (($fam->affiliate_status == '') | ($fam->affiliate_status == null))
                                                                        NO DISPONIBLE
                                                                    @else
                                                                        {{ $fam->affiliate_status }}
                                                                    @endif
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr
                                                            class="border-b border-neutral-200 bg-white dark:border-white/10 dark:bg-body-dark">
                                                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                                <p><strong>SEXO:</strong>
                                                                    {{ $fam->sex }}
                                                                </p>
                                                            </td>
                                                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                                                <p><strong>CAPACIDADES DIFERENTES:</strong>
                                                                    @if (($fam->disabled_person == '') | ($fam->disabled_person == null))
                                                                        NO DISPONIBLE
                                                                    @else
                                                                        {{ $fam->disabled_person }}
                                                                    @endif
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <strong>{{ $titular->file_number . ':' }}</strong> No tiene familiares registrados.
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

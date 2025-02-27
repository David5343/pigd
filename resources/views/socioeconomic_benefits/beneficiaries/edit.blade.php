<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prestaciones SocioEconómicas/Afiliación/Familiares/Editar') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                    @session('msg')
                        <div class="p-4" x-data="{ show: true }">
                            <div x-show="show" x-transition
                                class="inline-flex w-full items-center rounded-lg bg-green-100 px-6 py-5 text-base text-green-800 dark:bg-green-900 dark:text-green-300"
                                role="alert">
                                <span class="me-2 h-6 w-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="h-6 w-6">
                                        <path fill-rule="evenodd"
                                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <p>
                                    <strong>PIGD ¡Atención!</strong> {{ $value }}
                                </p>
                                <button @click="show = false" type="button"
                                    class="ms-auto box-content rounded-md border-none p-1 text-black opacity-50 hover:opacity-75 focus:outline-none dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="h-6 w-6">
                                        <path fill-rule="evenodd"
                                            d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endsession
                    @session('msg_warning')
                        <div class="p-4" x-data="{ show: true }">
                            <div x-show="show" x-transition
                                class="inline-flex w-full items-center rounded-lg bg-red-100 px-6 py-5 text-base text-red-800 dark:bg-red-900 dark:text-red-300"
                                role="alert">
                                <span class="me-2 h-6 w-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="h-6 w-6">
                                        <path fill-rule="evenodd"
                                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                                <p>
                                    <strong>PIGD ¡Atención!</strong> {{ $value }}
                                </p>
                                <button @click="show = false" type="button"
                                    class="ms-auto box-content rounded-md border-none p-1 text-black opacity-50 hover:opacity-75 focus:outline-none dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="h-6 w-6">
                                        <path fill-rule="evenodd"
                                            d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endsession
                    <h2 class="text-xl font-bold text-gray-700 mb-4 mt-4">Datos Generales</h2>
                    <h5 class="text-base font-bold text-gray-700 mb-4">(*) Campos Obligatorios.</h5>
                    <form method="POST" class="flex flex-wrap gap-2"
                        action="{{ url('socioeconomic_benefits/beneficiaries/' . $familiar->id) }}">
                        @method('PUT')
                        @csrf
                        @if ($errors->any())
                            <div class="w-full items-center rounded-lg bg-danger-100 px-6 py-5 text-base text-danger-700 dark:bg-[#2c0f14] dark:text-danger-500"
                                role="alert" id="alert-static-danger" data-twe-alert-init="">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="flex flex-col w-full md:w-32">
                            <label for="nombre" class="text-sm font-medium text-gray-700">* Folio</label>
                            <input type="text" id="file_number" name="file_number"
                                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200 bg-gray-300"
                                value="{{ $familiar->file_number }}" disabled>
                        </div>
                        <div class="flex flex-col w-full md:w-1/5">
                            <label for="fecha" class="text-sm font-medium text-gray-700">* Fecha de Ingreso</label>
                            <input type="date" id="start_date" name="start_date"
                                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                                value="{{ $familiar->start_date }}">
                        </div>

                        <div class="flex flex-col w-full md:w-1/3">
                            <label for="nombre" class="text-sm font-medium text-gray-700">* Apellido Paterno (Primer
                                Apellido)</label>
                            <input type="text" id="last_name_1" name="last_name_1"
                                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                                value="{{ $familiar->last_name_1 }}">
                        </div>
                        <div class="flex flex-col w-full md:w-1/3">
                            <label for="nombre" class="text-sm font-medium text-gray-700">Apellido Materno (Segundo
                                Apellido)</label>
                            <input type="text" id="last_name_2" name="last_name_2"
                                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                                value="{{ $familiar->last_name_2 }}">
                        </div>
                        <div class="flex flex-col w-full md:w-1/3">
                            <label for="nombre" class="text-sm font-medium text-gray-700">* Nombre</label>
                            <input type="text" id="name" name="name"
                                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                                value="{{ $familiar->name }}">
                        </div>
                        <div class="flex flex-col w-full md:w-1/5">
                            <label for="fecha" class="text-sm font-medium text-gray-700">Fecha de
                                Nacimiento</label>
                            <input type="date" id="birthday" name="birthday"
                                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                                value="{{ $familiar->birthday }}">
                        </div>
                        <!-- Radio Buttons (50% de ancho) -->
                        <fieldset class="flex flex-col w-full md:w-32">
                            <legend class="text-sm font-medium text-gray-700">Sexo</legend>
                            <div class="flex items-center gap-2">
                                <input type="radio" name="sex" id="male" value="Hombre"
                                    class="focus:ring focus:ring-blue-200" @checked($familiar->sex === 'Hombre')>
                                <label for="male">Hombre</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="radio" name="sex" id="female" value="Mujer"
                                    class="focus:ring focus:ring-blue-200" @checked($familiar->sex === 'Mujer')>
                                <label for="female">Mujer</label>
                            </div>
                        </fieldset>
                        <div class="flex flex-col w-full md:w-1/3">
                            <label for="nombre" class="text-sm font-medium text-gray-700">CURP</label>
                            <input type="text" id="curp" name="curp"
                                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                                value="{{ $familiar->curp }}">
                        </div>
                        <fieldset class="flex flex-col w-full md:w-1/5">
                            <legend class="text-sm font-medium text-gray-700">* ¿Con Diversas Capacidades?</legend>
                            <div class="flex items-center gap-2">
                                <input type="radio" name="disabled_person" id="yes" value="SI"
                                    class="focus:ring focus:ring-blue-200" @checked($familiar->disabled_person == 'SI')>
                                <label for="masculino">SI</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="radio" name="disabled_person" id="no" value="NO"
                                    class="focus:ring focus:ring-blue-200" @checked($familiar->disabled_person == 'NO')>
                                <label for="femenino">NO</label>
                            </div>
                        </fieldset>
                        <div class="flex flex-col w-full md:w-1/5">
                            <label for="relationship" class="text-sm font-medium text-gray-700">* Parentesco</label>
                            <select id="relationship" name="relationship"
                                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                                <option value="" @selected(old('relationship', $familiar->relationship) == '')>Elije...</option>
                                <option value="Padre" @selected(old('relationship', $familiar->relationship) == 'Padre')>Padre</option>
                                <option value="Madre" @selected(old('relationship', $familiar->relationship) == 'Madre')>Madre</option>
                                <option value="Esposa" @selected(old('relationship', $familiar->relationship) == 'Esposa')>Esposa</option>
                                <option value="Hijo/a" @selected(old('relationship', $familiar->relationship) == 'Hijo/a')>Hijo/a</option>
                                <option value="Concubina" @selected(old('relationship', $familiar->relationship) == 'Concubina')>Concubina</option>
                            </select>
                            @error('relationship')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col w-full md:w-3/4">
                            <label for="nombre" class="text-sm font-medium text-gray-700">* Direccion</label>
                            <input type="text" id="address" name="address"
                                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                                value="{{ $familiar->address }}">
                        </div>
                        <div class="flex flex-col w-full">
                            <label for="mensaje" class="text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea id="observations" name="observations" rows="3" minlength="5" maxlength="180"
                                placeholder="Observaciones..." class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">{{ $familiar->observations }}</textarea>
                        </div>
                        <!-- Botones alineados a la derecha -->
                        <div class="w-full flex justify-end gap-3 mt-4">
                            <a href="{{ route('beneficiaries.index') }}"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    @session('msg_busqueda')
        <div class="p-4" x-data="{ show: true }">
            <div x-show="show" x-transition
                class="inline-flex w-full items-center rounded-lg bg-yellow-100 px-6 py-5 text-base text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300"
                role="alert">
                <span class="me-2 h-6 w-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endsession
    @session('msg')
        <div class="p-4" x-data="{ show: true }">
            <div x-show="show" x-transition
                class="inline-flex w-full items-center rounded-lg bg-green-100 px-6 py-5 text-base text-green-800 dark:bg-green-900 dark:text-green-300"
                role="alert">
                <span class="me-2 h-6 w-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endsession
    <h2 class="text-xl font-bold text-gray-700 mb-4">Datos Generales</h2>
    <h5 class="text-base font-bold text-gray-700 mb-4">(*) Campos Obligatorios.</h5>
    <form wire:submit ="guardar" class="flex flex-wrap gap-2">

        <div class="flex flex-col w-full md:w-32">
            <label for="nombre" class="text-sm font-medium text-gray-700">Folio</label>
            <input wire:model="file_number" type="text" id="file_number" name="file_number"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200 bg-gray-300"
                value="{{ $folio }}" disabled>
        </div>
        <div class="flex flex-col w-full md:w-1/2">
            <label for="opcion" class="text-sm font-medium text-gray-700">* Subdependencia</label>
            <select wire:model="subdependency_id" id="subdependency_id" name="subdependency_id"
                value="{{ old('subdependency_id') }}"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                @foreach ($select1 as $sd)
                    <option value="{{ $sd->id }}">{{ $sd->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col w-full md:w-72">
            <label for="opcion" class="text-sm font-medium text-gray-700">* Categoria</label>
            <select wire:model="rank_id" id="rank_id" name="rank_id" value="{{ old('rank_id') }}"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                @foreach ($select5 as $sd)
                    <option value="{{ $sd->id }}">{{ $sd->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="fecha" class="text-sm font-medium text-gray-700">Fecha de Ingreso</label>
            <input wire:model="start_date" type="date" id="start_date" name="start_date"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-72">
            <label for="opcion" class="text-sm font-medium text-gray-700">Lugar de Trabajo</label>
            <select wire:model="work_place" id="work_place" name="work_place"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                @foreach ($select3 as $sd)
                    <option value="{{ $sd->name }}">{{ $sd->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="opcion" class="text-sm font-medium text-gray-700">* Estatus</label>
            <select wire:model="affiliate_status" id="affiliate_status" name="affiliate_status"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                <option>Preafiliado</option>
                <option>Activo</option>
            </select>
        </div>
        <div class="flex flex-col w-full">
            <label for="mensaje" class="text-sm font-medium text-gray-700">Motivo de alta</label>
            <textarea wire:model="register_motive" id="register_motive" name="register_motive" rows="3"
                placeholder="Se da de alta registro con oficio no. 456879 (Si aplica)..." minlength="3" maxlength="120"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"></textarea>
        </div>
        <div class="flex flex-col w-full">
            <label for="mensaje" class="text-sm font-medium text-gray-700">Observaciones</label>
            <textarea wire:model="observations" id="observations" name="observations" rows="3" minlength="5"
                maxlength="180" placeholder="Observaciones..."
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"></textarea>
        </div>
        <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Datos Personales</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="nombre" class="text-sm font-medium text-gray-700">* Apellido Paterno (Primer
                Apellido)</label>
            <input wire:model="last_name_1" type="text" id="last_name_1" name="last_name_1"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="nombre" class="text-sm font-medium text-gray-700">Apellido Materno (Segundo
                Apellido)</label>
            <input wire:model="last_name_2" type="text" id="last_name_2" name="last_name_2"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="nombre" class="text-sm font-medium text-gray-700">* Nombre</label>
            <input wire:model="name" type="text" id="name" name="name"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="opcion" class="text-sm font-medium text-gray-700">* Tipo de Sangre</label>
            <select wire:model="blood_type" id="blood_type" name="blood_type"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                <option>A+</option>
                <option>A-</option>
                <option>B+</option>
                <option>B-</option>
                <option>AB+</option>
                <option>AB-</option>
                <option>O+</option>
                <option>O-</option>
            </select>
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="fecha" class="text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
            <input wire:model="birthday" type="date" id="birthday" name="birthday"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-72">
            <label for="opcion" class="text-sm font-medium text-gray-700">Lugar de Nacimiento</label>
            <select wire:model="birthplace" id="birthplace" name="birthplace"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                @foreach ($select3 as $sd)
                    <option value="{{ $sd->name }}">{{ $sd->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Radio Buttons (50% de ancho) -->
        <fieldset class="flex flex-col w-full md:w-32">
            <legend class="text-sm font-medium text-gray-700">Sexo</legend>
            <div class="flex items-center gap-2">
                <input wire:model="sex" type="radio" name="sex" id="male" value="Hombre"
                    class="focus:ring focus:ring-blue-200">
                <label for="masculino">Hombre</label>
            </div>
            <div class="flex items-center gap-2">
                <input wire:model="sex" type="radio" name="sex" id="female" value="Mujer"
                    class="focus:ring focus:ring-blue-200">
                <label for="femenino">Mujer</label>
            </div>
        </fieldset>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="opcion" class="text-sm font-medium text-gray-700">Estado Civil</label>
            <select wire:model="marital_status" id="marital_status" name="marital_status"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                <option>Soltero/a</option>
                <option>Casado/a</option>
                <option>Divorciado/a</option>
                <option>Separado/a en proceso Judicial</option>
                <option>Viudo/a</option>
                <option>Union Libre</option>
                <option>Concubinato</option>
            </select>
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="nombre" class="text-sm font-medium text-gray-700">* RFC</label>
            <input wire:model="rfc" type="text" id="rfc" name="rfc"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="nombre" class="text-sm font-medium text-gray-700">CURP</label>
            <input wire:model="curp" type="text" id="curp" name="curp"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="telefono" class="text-sm font-medium text-gray-700">Teléfono</label>
            <input wire:model="phone" type="tel" id="phone" name="phone" placeholder="+52 999 123 4567"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/2">
            <label for="email" class="text-sm font-medium text-gray-700">Correo electrónico</label>
            <input wire:model="email" type="email" id="email" placeholder="correo@ejemplo.com"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Dirección</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="opcion" class="text-sm font-medium text-gray-700">Entidad Federativa</label>
            <select wire:model="state" id="state" name="state"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                @foreach ($select2 as $sd)
                    <option value="{{ $sd->name }}">{{ $sd->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="opcion" class="text-sm font-medium text-gray-700">Municipio</label>
            <select wire:model="county" id="county" name="county"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                @foreach ($select3 as $sd)
                    <option value="{{ $sd->name }}">{{ $sd->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="nombre" class="text-sm font-medium text-gray-700">Colonia</label>
            <input wire:model="neighborhood" type="text" id="neighborhood" name="neighborhood"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="nombre" class="text-sm font-medium text-gray-700">Tipo de Vialidad</label>
            <input wire:model="roadway_type" type="text" id="roadway_type" name="roadway_type"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="nombre" class="text-sm font-medium text-gray-700">Nombre de Vialidad (Calle)</label>
            <input wire:model="street" type="text" id="street" name="street"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-32">
            <label for="nombre" class="text-sm font-medium text-gray-700">No. de Exterior</label>
            <input wire:model="outdoor_number" type="text" id="outdoor_number" name="outdoor_number"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-32">
            <label for="nombre" class="text-sm font-medium text-gray-700">No. de Interior</label>
            <input wire:model="interior_number" type="text" id="interior_number" name="interior_number"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-32">
            <label for="nombre" class="text-sm font-medium text-gray-700">CP</label>
            <input wire:model="cp" type="text" id="cp" name="cp"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="nombre" class="text-sm font-medium text-gray-700">Localidad</label>
            <input wire:model="locality" type="text" id="locality" name="locality"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        {{-- <fieldset class="flex flex-col w-full md:w-1/2">
            <legend class="text-sm font-medium text-gray-700">Preferencias</legend>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="notificaciones" class="focus:ring focus:ring-blue-200">
                <label for="notificaciones">Recibir notificaciones</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="ofertas" class="focus:ring focus:ring-blue-200">
                <label for="ofertas">Recibir ofertas</label>
            </div>
        </fieldset> --}}
        <!-- Botones alineados a la derecha -->
        <div class="w-full flex justify-end gap-3 mt-4">
            <a href="{{ route('membership.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>

    </form>
</div>

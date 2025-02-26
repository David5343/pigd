<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Datos Generales</h2>
    <h5 class="text-base font-bold text-gray-700 mb-4">(*) Campos Obligatorios.</h5>
    <form wire:submit ="guardar" class="flex flex-wrap gap-2">

        <div class="flex flex-col w-full md:w-32">
            <label for="nombre" class="text-sm font-medium text-gray-700">Folio</label>
            <input type="text" id="file_number" name="file_number"
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
                    <option value="{{ $sd->id }}">{{ $sd->name }}</option>
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
            <textarea wire:model="observations" id="observations" name="observations" rows="3" minlength="5" maxlength="180"
                placeholder="Observaciones..." class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"></textarea>
        </div>
        <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Datos Personales</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="nombre" class="text-sm font-medium text-gray-700">* Apellido Paterno (Primer Apellido)</label>
            <input wire:model="last_name_1" type="text" id="last_name_1" name="last_name_1"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="nombre" class="text-sm font-medium text-gray-700">Apellido Materno (Segundo Apellido)</label>
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
                    <option value="{{ $sd->id }}">{{ $sd->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Radio Buttons (50% de ancho) -->
        <fieldset class="flex flex-col w-full md:w-32">
            <legend class="text-sm font-medium text-gray-700">Sexo</legend>
            <div class="flex items-center gap-2">
                <input type="radio" name="sex" id="male" class="focus:ring focus:ring-blue-200">
                <label for="masculino">Masculino</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="sex" id="female" class="focus:ring focus:ring-blue-200">
                <label for="femenino">Femenino</label>
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
            <input type="text" id="rfc" name="rfc"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="nombre" class="text-sm font-medium text-gray-700">CURP</label>
            <input type="text" id="curp" name="curp"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="telefono" class="text-sm font-medium text-gray-700">Teléfono</label>
            <input type="tel" id="phone" name="phone" placeholder="+52 999 123 4567"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/2">
            <label for="email" class="text-sm font-medium text-gray-700">Correo electrónico</label>
            <input type="email" id="email" placeholder="correo@ejemplo.com"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Dirección</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="opcion" class="text-sm font-medium text-gray-700">Entidad Federativa</label>
            <select wire:model="work_place" id="work_place" name="work_place"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                @foreach ($select2 as $sd)
                    <option value="{{ $sd->id }}">{{ $sd->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="opcion" class="text-sm font-medium text-gray-700">Municipio</label>
            <select wire:model="work_place" id="work_place" name="work_place"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                @foreach ($select3 as $sd)
                    <option value="{{ $sd->id }}">{{ $sd->name }}</option>
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
        <fieldset class="flex flex-col w-full md:w-1/2">
            <legend class="text-sm font-medium text-gray-700">Preferencias</legend>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="notificaciones" class="focus:ring focus:ring-blue-200">
                <label for="notificaciones">Recibir notificaciones</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="ofertas" class="focus:ring focus:ring-blue-200">
                <label for="ofertas">Recibir ofertas</label>
            </div>
        </fieldset>
        <!-- Botones alineados a la derecha -->
        <div class="w-full flex justify-end gap-3 mt-4">
            <button type="reset"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Cancelar</button>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>

    </form>
</div>

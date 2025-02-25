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
        <div class="flex flex-col w-full md:w-1/2">
            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" placeholder="correo@ejemplo.com"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>

        <!-- Teléfono (33% de ancho) -->
        <div class="flex flex-col w-full md:w-1/3">
            <label for="telefono" class="text-sm font-medium text-gray-700">Teléfono</label>
            <input type="tel" id="telefono" placeholder="+52 999 123 4567"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>

        <!-- Hora (50% de ancho) -->
        <div class="flex flex-col w-full md:w-1/2">
            <label for="hora" class="text-sm font-medium text-gray-700">Hora</label>
            <input type="time" id="hora"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>

        <!-- Radio Buttons (50% de ancho) -->
        <fieldset class="flex flex-col w-full md:w-1/2">
            <legend class="text-sm font-medium text-gray-700">Género</legend>
            <div class="flex items-center gap-2">
                <input type="radio" name="genero" id="masculino" class="focus:ring focus:ring-blue-200">
                <label for="masculino">Masculino</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="genero" id="femenino" class="focus:ring focus:ring-blue-200">
                <label for="femenino">Femenino</label>
            </div>
        </fieldset>

        <!-- Checkbox (50% de ancho) -->
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

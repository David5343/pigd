<div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Datos Generales</h2>
    <h5 class="text-base font-bold text-gray-700 mb-4">(*) Campos Obligatorios.</h5>
    <form wire:submit ="guardar" class="flex flex-wrap gap-2">

        <div class="flex flex-col w-full md:w-32">
            <label for="nombre" class="text-sm font-medium text-gray-700">Folio</label>
            <input type="text" id="file_number" name="file_number"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200 bg-gray-300"
                value="{{ $folio }}" disabled>
        </div>
        <div class="flex flex-col w-full md:w-90">
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
        <!-- Email (50% de ancho) -->
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

        <!-- Fecha (33% de ancho) -->
        <div class="flex flex-col w-full md:w-1/3">
            <label for="fecha" class="text-sm font-medium text-gray-700">Fecha</label>
            <input type="date" id="fecha"
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

        <!-- Textarea (Ocupa toda la fila) -->
        <div class="flex flex-col w-full">
            <label for="mensaje" class="text-sm font-medium text-gray-700">Mensaje</label>
            <textarea id="mensaje" rows="3" placeholder="Escribe tu mensaje..."
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"></textarea>
        </div>

        <!-- Botones alineados a la derecha -->
        <div class="w-full flex justify-end gap-3 mt-4">
            <button type="reset"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Cancelar</button>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>

    </form>
</div>

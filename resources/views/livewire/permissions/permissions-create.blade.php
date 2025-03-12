<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    @if (session()->has('msg'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 7000)" x-show="show"
            class="w-full bg-green-100 text-green-700 p-4 rounded-lg mb-4" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    @if (session()->has('msg_warning'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
            class="w-full bg-red-100 text-red-700 p-4 rounded-lg mb-4" role="alert">
            {{ session('msg') }}
        </div>
    @endif
    <h2 class="text-xl font-bold text-gray-700 mb-4 mt-4">Permisos de Sistema.</h2>
    <h5 class="text-base font-bold text-gray-700 mb-4">Convencion de Nombres (Ejemplo:usuarios.create)</h5>
    <form wire:submit ="guardar" class="flex flex-wrap gap-2">
        @if ($errors->any())
            <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                <ul class="list-disc pl-5 space-y-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="flex flex-col w-full">
            <div class="flex flex-col w-full md:w-1/3">
                <label for="nombre" class="text-sm font-medium text-gray-700">* Nombre</label>
                <input wire:model="name" type="text" id="name" name="name"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
            </div>
        </div>
        @error('name')
            <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                {{ $message }}
            </div>
        @enderror
        <div class="flex flex-col w-full">
            <div class="flex flex-col w-full md:w-1/3">
                <label for="opcion" class="text-sm font-medium text-gray-700">Grupo al que pertenece:</label>
                <select wire:model="category" id="category" name="category"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                    <option selected value="">Elije...</option>
                    <option>CoordinacionGeneral</option>
                    <option>AdministracionGeneral</option>
                    <option>AreaJuridica</option>
                    <option>CoordinacionMedica</option>
                    <option>RecursosHumanos</option>
                    <option>RecursosFinancieros</option>
                    <option>RecursosMateriales</option>
                    <option>PrestacionesSocioEconomicas</option>
                    <option>Tecnologias</option>
                </select>
            </div>
        </div>
        @error('category')
            <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                {{ $message }}
            </div>
        @enderror
        <!-- Botones alineados a la derecha -->
        <div class="w-full flex justify-end gap-3 mt-4">
            <a href="{{ route('permissions.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>
    </form>
</div>

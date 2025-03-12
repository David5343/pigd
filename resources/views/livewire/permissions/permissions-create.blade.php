<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <!-- Modal -->
    <div x-data="{ open: false, message: '', type: '' }"
        x-on:show-modal.window="
       open = true;
       message = $event.detail.message;
       type = $event.detail.type;
       console.log('Mensaje recibido:', message, 'Tipo:', type);
    ">

        <div x-show="open" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500 bg-opacity-75">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold"
                        :class="{ 'text-green-600': type === 'success', 'text-red-600': type === 'warning' }">
                        <span x-text="type === 'success' ? '¡Éxito!' : '¡Advertencia!'"></span>
                    </h2>
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                            <path fill-rule="evenodd"
                                d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <p class="mt-4" x-text="message" x-effect="console.log('Mensaje actualizado:', message)"></p>
            </div>
        </div>
    </div>

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

<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
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
    <h5 class="text-base font-bold text-gray-700 mb-4">Ingresa los datos del usuario,selecciona el Rol y Los Permisos
    </h5>
    <div class="flex flex-col w-full md:w-1/3">
        <label for="nombre" class="text-sm font-medium text-gray-700">* Nombre</label>
        <input wire:model="name" type="text" id="name" name="name"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
    </div>
    <div class="flex flex-col w-full md:w-1/3">
        <label for="email" class="text-sm font-medium text-gray-700">Correo electrónico</label>
        <input wire:model="email" type="email" id="email" placeholder="correo@ejemplo.com"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
    </div>
    <div class="flex flex-col w-full md:w-1/3">
        <label for="password" class="text-sm font-medium text-gray-700">Contraseña</label>
        <input wire:model="password" type="password" placeholder="******"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
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
    <h2 class="text-xl font-bold text-gray-700 mb-4 mt-4">Roles</h2>
    <form wire:submit ="guardar" class="flex flex-wrap gap-2">
        @foreach ($roles as $role)
            <div class="flex flex-col w-1/3">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-14 h-7 bg-gray-300 peer-checked:bg-blue-500 rounded-full relative">
                        <div
                            class="w-6 h-6 bg-white rounded-full absolute top-0.5 left-0.5 peer-checked:left-7 transition-all">
                        </div>
                    </div>
                    <span class="ml-3 text-gray-700">Opción 1</span>
                </label>
            </div>
        @endforeach
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

<div class="m-3">
    <livewire:messages />
    <form wire:submit.prevent="guardar" class="flex flex-wrap gap-2">
        @if ($errors->any())
            <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                <ul class="list-disc pl-5 space-y-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="flex flex-col w-full md:w-3/4">
                <label for="nombre" class="text-sm font-medium text-gray-700">* Nombre</label>
                <input wire:model="name" type="text" id="name" name="name"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                     @error('name')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                    {{ $message }}
                </div>
            @enderror
            </div>
            <div class="flex flex-col w-full md:w-1/6">
                <label for="nombre" class="text-sm font-medium text-gray-700">* RFC</label>
                <input wire:model="rfc" type="text" id="rfc" name="rfc"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                    @error('rfc')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                    {{ $message }}
                </div>
            @enderror
            </div>
            <div class="flex flex-col w-full md:w-1/2">
                <label for="nombre" class="text-sm font-medium text-gray-700">* Email</label>
                <input wire:model="email" type="email" id="email" name="email"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                                @error('email')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                    {{ $message }}
                </div>
            @enderror
            </div>
<div class="flex flex-col w-full md:w-1/6">
    <label for="office_phone" class="text-sm font-medium text-gray-700 mb-1">* Teléfono de oficina</label>

    <div class="relative">
        <!-- Ícono de teléfono a la izquierda -->
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
            </svg>
        </div>

        <!-- Campo de entrada -->
        <input
            wire:model="office_phone"
            type="tel"
            id="office_phone"
            name="office_phone"
            inputmode="numeric"
            pattern="[0-9]*"
            maxlength="10"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            class="border rounded-lg pl-10 pr-3 py-2 w-full focus:ring focus:ring-blue-200"
            required
        >
    </div>

    <!-- Error -->
    @error('office_phone')
        <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 mt-1 rounded-lg" role="alert">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="flex flex-col w-full md:w-1/6">
    <label for="mobile_phone" class="text-sm font-medium text-gray-700 mb-1">* Teléfono celular</label>

    <div class="relative">
        <!-- Ícono de teléfono a la izquierda -->
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
</svg>

        </div>

        <!-- Campo de entrada -->
        <input
            wire:model="mobile_phone"
            type="tel"
            id="mobile_phone"
            name="mobile_phone"
            inputmode="numeric"
            pattern="[0-9]*"
            maxlength="10"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            class="border rounded-lg pl-10 pr-3 py-2 w-full focus:ring focus:ring-blue-200"
            required
        >
    </div>

    <!-- Error -->
    @error('mobile_phone')
        <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 mt-1 rounded-lg" role="alert">
            {{ $message }}
        </div>
    @enderror
</div>
            <div class="flex flex-col w-full md:w-3/4">
                <label for="nombre" class="text-sm font-medium text-gray-700">* Dirección</label>
                <input wire:model="address" type="text" id="address" name="address"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                        @error('address')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                    {{ $message }}
                </div>
            @enderror
            </div>
        <div class="flex flex-col w-full md:w-1/6">
            <label for="degree_id" class="text-sm font-medium text-gray-700">* ¿Que vende?</label>
            <select wire:model="type" id="type" name="type"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                <option value="producto">Elije...</option>
                    <option value="producto">producto</option>
                    <option value="servicio">servicio</option>
                    <option value="ambos">ambos</option>
            </select>
            @error('type')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
<div class="flex flex-col w-full m-4">
    <label class="text-sm font-medium text-gray-700 mb-2">* Categorías</label>
    <div class="flex flex-wrap gap-4">
     @foreach ($categories as $item)
        <label class="flex items-center cursor-pointer">
            <input type="checkbox"
            wire:model="selectedCategories" value="{{ $item->id }}"
                class="sr-only peer">
             <div
                class="w-10 h-5 bg-gray-300 rounded-full peer-checked:bg-blue-600 relative transition duration-300">
                <div
                    class="absolute left-1 top-1 w-3.5 h-3.5 bg-white rounded-full transition duration-300 peer-checked:translate-x-5">
                    </div>
                    </div>
                    <span class="ml-2">{{ $item->name }}</span>
                     </label>
    @endforeach
    </div>
    @error('selectedCategories')
        <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
    @enderror
</div>
        <div class="w-full flex justify-end gap-3 m-4">
            <a href="{{ route('supplier.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>
    </form>
</div>

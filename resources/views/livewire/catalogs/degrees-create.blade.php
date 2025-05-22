<div>
    <livewire:messages />
    <form wire:submit.prevent="guardar" class="flex flex-wrap gap-2 m-4">
        @if ($errors->any())
            <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                <ul class="list-disc pl-5 space-y-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="flex flex-col w-full md:w-1/2">
            <label for="name" class="text-sm font-medium text-gray-700">* Nombre</label>
            <input wire:model="name" type="text" id="name" name="name"
                placeholder="LICENCIATURA EN CONTADURÍA PÚBLICA" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('name')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/12">
            <label for="abbreviation" class="text-sm font-medium text-gray-700">* Abreviatura</label>
            <input wire:model="abbreviation" type="text" id="abbreviation" name="abbreviation" placeholder="Lic."
                required class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('abbreviation')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="w-full flex justify-end gap-3 m-4">
            <a href="{{ route('degrees.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>
    </form>
</div>

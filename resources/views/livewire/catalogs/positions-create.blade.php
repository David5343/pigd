<div>
    <livewire:messages />
    <form wire:submit.prevent ="guardar" class="flex flex-wrap gap-2">
        @if ($errors->any())
            <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                <ul class="list-disc pl-5 space-y-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="flex flex-col w-full m-4">
            <div class="flex flex-col w-full md:w-1/6">
                <label for="name" class="text-sm font-medium text-gray-700">* No. de puesto</label>
                <input wire:model="position_number" type="text" id="position_number" name="position_number"
                    placeholder="000" maxlength="3" required
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            </div>
            @error('position_number')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full m-4">
            <div class="flex flex-col w-full md:w-1/2">
                <label for="salary" class="text-sm font-medium text-gray-700">* Nombre del puesto</label>
                <input wire:model="position_name" type="text" id="position_name" name="position_name" maxlength="80"
                    placeholder="Analista" required
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            </div>
            @error('position_name')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full m-4">
            <div class="flex flex-col w-full md:w-1/3">
                <label for="opcion" class="text-sm font-medium text-gray-700">Categoria</label>
                <select wire:model="category_id" id="category_id" name="category_id"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                    <option selected value="">Elije...</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('category_id')
            <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                {{ $message }}
            </div>
        @enderror
        <!-- Botones alineados a la derecha -->
        <div class="w-full flex justify-end gap-3 m-4">
            <a href="{{ route('positions.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>
    </form>
</div>

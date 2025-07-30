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
            <div class="flex flex-col w-full md:w-1/6">
                <label for="nombre" class="text-sm font-medium text-gray-700">* Número de lote</label>
                <input wire:model="batch_number" type="text" id="batch_number" name="batch_number"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                @error('batch_number')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                    {{ $message }}
                </div>
            @enderror
            </div>
            <div class="flex flex-col w-full">
                <label for="nombre" class="text-sm font-medium text-gray-700">* Nombre</label>
                <textarea wire:model="name" id="name" name="name"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" 
                    rows="3" minlength="5" maxlength="244" required></textarea>
            @error('name')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                    {{ $message }}
                </div>
            @enderror
            </div>
            <div class="flex flex-col w-full md:w-1/2">
                <label for="nombre" class="text-sm font-medium text-gray-700">* Nombre comercial</label>
                <input wire:model="commercial_name" type="text" id="commercial_name" name="commercial_name"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                @error('commercial_name')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                    {{ $message }}
                </div>
            @enderror
            </div>
            <div class="flex flex-col w-full md:w-1/6">
                <label for="medication_units_id" class="text-sm font-medium text-gray-700">* Unidad de medida</label>
                <select wire:model="medication_units_id" id="medication_units_id" name="medication_units_id"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                    <option selected value="">Elije...</option>
                    @foreach ($medication_units as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            @error('medication_units_id')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                    {{ $message }}
                </div>
            @enderror
            </div>
            <div class="flex flex-col w-full md:w-1/2">
                <label for="supplier_id" class="text-sm font-medium text-gray-700">* Proveedor</label>
                <select wire:model="supplier_id" id="supplier_id" name="supplier_id"
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                    <option selected value="">Elije...</option>
                    @foreach ($suppliers as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                    @error('supplier_id')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                    {{ $message }}
                </div>
            @enderror
            </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="expiration_date" class="text-sm font-medium text-gray-700">Fecha de caducidad</label>
            <input wire:model="expiration_date" type="date" id="expiration_date" name="expiration_date" 
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('expiration_date')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="w-full flex justify-end gap-3 m-4">
            <a href="{{ route('medication.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>
    </form>
</div>

    {{-- Modal para agregar precio --}}
    <div>
    @if ($visible)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
            <h2 class="text-lg font-bold mb-4">Asignar precio al medicamento</h2>
            <h1 class="text-sm m-2">Número de lote: {{ $batchNumber }}</h1>
            <h1 class="text-sm m-2">Nombre comercial:{{ $commercialName }}</h1>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Año del catálogo</label>
                <select wire:model="selectedYearId" class="mt-1 block w-full border border-gray-300 rounded p-2">
                    <option value="">Selecciona un año</option>
                    @foreach ($catalog_years as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
                @error('selectedYearId')
                    <div class="w-full bg-red-100 text-red-700 p-2 mt-2 rounded">
                        {{ $message }}
                    </div>
                @enderror                
            </div>
<div class="mb-3">
    <label for="price_integer" class="text-sm font-medium text-gray-700">* Precio unitario</label> 
    <div class="flex items-center gap-1">
        <div class="relative w-3/4">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none">$</span>
            <input wire:model.lazy="price_integer"
                type="text"
                id="price_integer"
                maxlength="10"
                pattern="[0-9]*"
                inputmode="numeric"
                class="pl-7 border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                placeholder="1234567890" />
        </div>

        <span class="text-xl font-semibold">.</span>

        <input wire:model.lazy="price_decimal"
            type="text"
            id="price_decimal"
            maxlength="2"
            pattern="[0-9]*"
            inputmode="numeric"
            class="border rounded-lg px-3 py-2 w-1/4 focus:ring focus:ring-blue-200"
            placeholder="00" />
    </div>

    @error('price_integer')
        <div class="w-full bg-red-100 text-red-700 p-2 mt-2 rounded">
            {{ $message }}
        </div>
    @enderror
        @error('price_decimal')
        <div class="w-full bg-red-100 text-red-700 p-2 mt-2 rounded">
            {{ $message }}
        </div>
    @enderror
</div>
            <div class="flex justify-end gap-2">
                <button wire:click="guardarPrecio" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Guardar
                </button>
                <button wire:click="$dispatchTo('catalogs.medication-set-price','closeModal')" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    Cancelar
                </button>
            </div>
            <div class="flex justify-center gap-2">
                @php
                    $alertClasses = match ($type) {
                        'success' => 'bg-green-100 text-green-700',
                        'error' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                @if ($message)
                    <div class="mt-4 p-3 rounded text-lg {{ $alertClasses }}">
                        {{ $message }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
</div>
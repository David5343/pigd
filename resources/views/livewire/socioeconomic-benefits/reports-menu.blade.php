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
        <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Reportes de Afiliación</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="position_id" class="text-sm font-medium text-gray-700">Reporte de:</label>
            <select wire:model="position_id" id="position_id" name="position_id"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                <option value="">Elije...</option>
                <option value="">Titulares</option>
                <option value="">Familiares</option>
                <option value="">Pensionados</option>
                <option value="">Beneficiarios</option>
            </select>
            @error('position_id')
                <div class="bg-red-100 text-red-700 p-2 rounded-lg mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="area_id" class="text-sm font-medium text-gray-700">* Area de adscripción</label>
            <select wire:model="area_id" id="area_id" name="area_id"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                <option value="">Elije...</option>
                {{-- @foreach ($areas as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach --}}
            </select>
            @error('area_id')
                <div class="bg-red-100 text-red-700 p-2 rounded-lg mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="effective_date" class="text-sm font-medium text-gray-700">* Fecha de aplicación</label>
            <input wire:model="effective_date" type="date" id="effective_date" name="effective_date" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('effective_date')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="w-full flex justify-end gap-3 m-4">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>
    </form>
</div>

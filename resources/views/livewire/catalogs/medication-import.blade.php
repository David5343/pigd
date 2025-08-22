<div class="p-4 bg-white rounded shadow">
        <livewire:messages />
    <form wire:submit.prevent="import">
        @if ($errors->any())
            <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
                <ul class="list-disc pl-5 space-y-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
<div class="flex w-full"> 
    <div class="flex flex-col w-full  px-4 py-2 md:w-1/2">
        <label for="file" class="text-sm font-medium text-gray-700">* Año del catalogo</label>
                <select wire:model="selectedYearId" class="mt-1 block w-full border border-gray-300 rounded p-2">
                    <option value="">Selecciona un año</option>
                    @foreach ($catalog_years as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
        @error('selectedYearId')
        <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
    <div class="flex flex-col w-full  px-4 py-2 md:w-1/2">
        <label for="file" class="text-sm font-medium text-gray-700">* Importar archivo de medicamentos</label>
        <input wire:model="file" type="file" id="file" name="file"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
        @error('file')
        <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg" role="alert">
            {{ $message }}
        </div>
        @enderror
    </div> 
        <div class="flex flex-col justify-end w-full md:w-1/12">
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Importar</button>
    </div> 
    </form>
</div>
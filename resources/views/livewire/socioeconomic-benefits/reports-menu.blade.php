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
<div class="flex flex-wrap w-full gap-4">

    <!-- Reporte de -->
    <div class="flex flex-col w-full md:w-1/5">
        <label class="text-sm font-medium text-gray-700">Reporte de:</label>
        <select wire:model="report_type" id="report_type" name="report_type"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
            <option value="">Altas</option>
            <option value="">Bajas</option>
            <option value="">Preafiliados</option>
        </select>

        @error('report_type')
            <div class="bg-red-100 text-red-700 p-2 rounded-lg mt-2">{{ $message }}</div>
        @enderror
    </div>

    <!-- Tipo de derechohabiente -->
    <div class="flex flex-col w-full md:w-1/5">
        <label class="text-sm font-medium text-gray-700">Tipo de derechohabiente</label>
        <select wire:model="insured_type" id="insured_type" name="insured_type"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
            <option value="">Titulares</option>
            <option value="">Familiares</option>
            <option value="">Pensionados</option>
            <option value="">Beneficiarios</option>
        </select>

        @error('insured_type')
            <div class="bg-red-100 text-red-700 p-2 rounded-lg mt-2">{{ $message }}</div>
        @enderror
    </div>

</div>
<div class="flex flex-wrap w-full gap-4 mt-4">

    <!-- Fecha inicio -->
    <div class="flex flex-col w-full md:w-1/4">
        <label class="text-sm font-medium text-gray-700">Fecha inicio</label>
        <input wire:model="effective_date_start" type="date" id="effective_date_start" name="effective_date_start"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>

        @error('effective_date_start')
            <div class="bg-red-100 text-red-700 p-2 rounded-lg mt-2">{{ $message }}</div>
        @enderror
    </div>

    <!-- Fecha final -->
    <div class="flex flex-col w-full md:w-1/4">
        <label class="text-sm font-medium text-gray-700">Fecha final</label>
        <input wire:model="effective_date_end" type="date" id="effective_date_end" name="effective_date_end"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>

        @error('effective_date_end')
            <div class="bg-red-100 text-red-700 p-2 rounded-lg mt-2">{{ $message }}</div>
        @enderror
    </div>

</div>
        <div class="w-full flex justify-end gap-3 m-4">
            <a href="{{ route('banks.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Generar</button>
        </div>
    </form>
</div>

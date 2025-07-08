<div class="m-3">
    <livewire:messages />
    {{-- <form class="flex flex-wrap gap-2"> --}}
    <div class="flex flex-wrap gap-2">
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
            <h2 class="text-xl font-bold text-gray-700 mb-4">Movimiento nominal</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="procedureType" class="text-sm font-medium text-gray-700">* Seleccione para iniciar el
                proceso</label>
            <select wire:model.live="procedureType" id="procedureType" name="procedureType"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                <option value="">Elije...</option>
                @foreach ($procedure_types as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}
                    </option>
                @endforeach
            </select>
            @error('procedureType')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        @if ($procedureType === '1')
            @livewire('form1')
        @elseif ($procedureType === '2')
            <livewire:human-resources.employees-create :procedure-type="$procedureType" />
        @elseif ($procedureType === '3')
            @livewire('form2')
        @elseif ($procedureType === '4')
            @livewire('form2')
        @endif
        <div class="w-full flex justify-end gap-3 m-4">
            <a href="{{ route('employee-procedure.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            {{-- <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button> --}}
        </div>
    </div>
    {{-- </form> --}}
</div>

<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    @if (session()->has('msg'))
        <div x-data="{ show: true }" x-show="show" class="w-full bg-green-100 text-green-700 p-4 rounded-lg mb-4"
            role="alert">
            {{ session('msg') }}
        </div>
    @endif

    @if (session()->has('msg_warning'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            class="w-full bg-red-100 text-red-700 p-4 rounded-lg mb-4" role="alert">
            {{ session('msg') }}
        </div>
    @endif
    <form wire:submit ="guardar" class="flex flex-wrap gap-2">
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
            <div class="flex flex-col w-full md:w-1/2">
                <label for="name" class="text-sm font-medium text-gray-700">* Nombre</label>
                <input wire:model="name" type="text" id="name" name="name" maxlength="80" required
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            </div>
            @error('name')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full" x-data>
            <div class="flex flex-col w-full md:w-1/5">
                <label for="salary" class="text-sm font-medium text-gray-700">* Salario</label>
                <input wire:model.defer="salary" type="text" id="salary" name="salary" maxlength="13"
                    inputmode="decimal" required
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                    placeholder="Ej. 123456.78" x-ref="salaryInput"
                    @blur="
                        let val = $refs.salaryInput.value.replace(',', '.');
                        let num = parseFloat(val);
                        if (!isNaN(num)) {
                            $refs.salaryInput.value = num.toFixed(2);
                        }
                    ">
            </div>
            @error('salary')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full" x-data>
            <div class="flex flex-col w-full md:w-1/5">
                <label for="salary" class="text-sm font-medium text-gray-700">* Compensación</label>
                <input wire:model.defer="compensation" type="text" id="compensation" name="compensation"
                    maxlength="13" inputmode="decimal" required
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                    placeholder="Ej. 123456.78" x-ref="salaryInput"
                    @blur="
                        let val = $refs.salaryInput.value.replace(',', '.');
                        let num = parseFloat(val);
                        if (!isNaN(num)) {
                            $refs.salaryInput.value = num.toFixed(2);
                        }
                    ">
            </div>
            @error('compensation')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full" x-data>
            <div class="flex flex-col w-full md:w-1/5">
                <label for="complementary" class="text-sm font-medium text-gray-700">* Complementaria</label>
                <input wire:model.defer="complementary" type="text" id="complementary" name="complementary"
                    maxlength="13" inputmode="decimal" required
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                    placeholder="Ej. 123456.78" x-ref="salaryInput"
                    @blur="
                        let val = $refs.salaryInput.value.replace(',', '.');
                        let num = parseFloat(val);
                        if (!isNaN(num)) {
                            $refs.salaryInput.value = num.toFixed(2);
                        }
                    ">
            </div>
            @error('complementary')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full" x-data>
            <div class="flex flex-col w-full md:w-1/5">
                <label for="isr" class="text-sm font-medium text-gray-700">* ISR</label>
                <input wire:model.defer="isr" type="text" id="isr" name="isr" maxlength="13"
                    inputmode="decimal" required
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"
                    placeholder="Ej. 123456.78" x-ref="salaryInput"
                    @blur="
                        let val = $refs.salaryInput.value.replace(',', '.');
                        let num = parseFloat(val);
                        if (!isNaN(num)) {
                            $refs.salaryInput.value = num.toFixed(2);
                        }
                    ">
            </div>
            @error('isr')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full">
            <div class="flex flex-col w-full md:w-1/6">
                <label for="authorized_positions" class="text-sm font-medium text-gray-700">* Puestos
                    autorizados</label>
                <input wire:model="authorized_position" type="number" id="authorized_position"
                    name="authorized_position" required
                    class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            </div>
            @error('authorized_position')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <!-- Botones alineados a la derecha -->
        <div class="w-full flex justify-end gap-3 mt-4">
            <a href="{{ route('categories.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>
    </form>
</div>

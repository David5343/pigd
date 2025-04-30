<div>
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
            <h2 class="text-xl font-bold text-gray-700 mb-4">Información Laboral</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="mov_type" class="text-sm font-medium text-gray-700">* Movimiento Nominal</label>
            <select wire:model="mov_type" id="mov_type" name="mov_type"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                <option selected value="">Elije...</option>
                <option>Cambio de Adscripción</option>
                <option>Cambio de Puesto</option>
                <option>Deceso</option>
                <option>Incremento Anual Salarial</option>
                <option>Licencia con goce de sueldo</option>
                <option>Licencia sin goce de sueldo</option>
                <option>Nuevo ingreso</option>
                <option>Reingreso</option>
                <option>Renuncia</option>
                <option>Recategorización</option>
            </select>
            @error('mov_type')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="contract_type" class="text-sm font-medium text-gray-700">* Tipo de relacion laboral</label>
            <select wire:model="contract_type" id="contract_type" name="contract_type"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                <option selected value="">Elije...</option>
                <option>Estructura</option>
                <option>Eventual</option>
                <option>Permanente</option>
            </select>
            @error('contract_type')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="position_id" class="text-sm font-medium text-gray-700">* Puesto</label>
            <select wire:model="position_id" id="position_id" name="position_id"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                <option value="">Elije...</option>
                @foreach ($positions as $item)
                    <option value="{{ $item->id }}">{{ $item->position_number . '-' . $item->position_name }}
                    </option>
                @endforeach
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
                @foreach ($areas as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            @error('area_id')
                <div class="bg-red-100 text-red-700 p-2 rounded-lg mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="start_date" class="text-sm font-medium text-gray-700">* Fecha de ingreso</label>
            <input wire:model="start_date" type="date" id="start_date" name="start_date" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('start_date')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Información Personal</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="last_name_1" class="text-sm font-medium text-gray-700">* Primer Apellido</label>
            <input wire:model="last_name_1" type="text" id="last_name_1" name="last_name_1" placeholder="Pérez"
                required class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('last_name_1')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="last_name_2" class="text-sm font-medium text-gray-700">* Segundo Apellido</label>
            <input wire:model="last_name_2" type="text" id="last_name_2" name="last_name_2" placeholder="López"
                required class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('last_name_2')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="name" class="text-sm font-medium text-gray-700">* Nombre</label>
            <input wire:model="name" type="text" id="name" name="name" placeholder="Juan" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('name')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="birthday" class="text-sm font-medium text-gray-700">* Fecha de nacimiento</label>
            <input wire:model="birthday" type="date" id="birthday" name="birthday" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('birthday')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <fieldset class="flex flex-col w-full md:w-32">
            <legend class="text-sm font-medium text-gray-700">* Sexo</legend>
            <div class="flex items-center gap-2">
                <input wire:model="sex" type="radio" name="sex" id="male" value="Hombre"
                    class="focus:ring focus:ring-blue-200">
                <label for="masculino">Hombre</label>
            </div>
            <div class="flex items-center gap-2">
                <input wire:model="sex" type="radio" name="sex" id="female" value="Mujer"
                    class="focus:ring focus:ring-blue-200">
                <label for="femenino">Mujer</label>
            </div>
            @error('sex')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </fieldset>
        <fieldset class="flex flex-col w-full md:w-32">
            <legend class="text-sm font-medium text-gray-700">* Estado Civil</legend>
            <div class="flex items-center gap-2">
                <input wire:model="marital_status" type="radio" name="marital_status" id="Soltero/a"
                    value="Soltero/a" class="focus:ring focus:ring-blue-200">
                <label for="Soltero/a">Soltero/a</label>
            </div>
            <div class="flex items-center gap-2">
                <input wire:model="marital_status" type="radio" name="marital_status" id="Casado/a"
                    value="Casado/a" class="focus:ring focus:ring-blue-200">
                <label for="Casado/a">Casado/a</label>
            </div>
            <div class="flex items-center gap-2">
                <input wire:model="marital_status" type="radio" name="marital_status" id="Concubinato"
                    value="Concubinato" class="focus:ring focus:ring-blue-200">
                <label for="Concubinato">Concubinato</label>
            </div>
            @error('marital_status')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </fieldset>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="rfc" class="text-sm font-medium text-gray-700">* RFC</label>
            <input wire:model="rfc" type="text" id="rfc" name="rfc" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('rfc')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="curp" class="text-sm font-medium text-gray-700">* CURP</label>
            <input wire:model="curp" type="text" id="curp" name="curp" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('curp')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/6">
            <label for="phone" class="text-sm font-medium text-gray-700">* Teléfono</label>
            <input wire:model="phone" type="tel" id="phone" name="phone" placeholder="Ej. 961-123-4567"
                required class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('phone')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="email" class="text-sm font-medium text-gray-700">* Correo electrónico</label>
            <input wire:model="email" type="email" id="email" name="email"
                placeholder="example@pigd.gob.mx" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('email')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Contacto de Emergencia</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="emergency_name" class="text-sm font-medium text-gray-700">* Nombre</label>
            <input wire:model="emergency_name" type="text" id="emergency_name" name="emergency_name" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('emergency_name')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="emergency_number" class="text-sm font-medium text-gray-700">* No. de Teléfono</label>
            <input wire:model="emergency_number" type="text" id="emergency_number" name="emergency_number"
                placeholder="Ej. 961-123-4567" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('emergency_number')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/2">
            <label for="emergency_address" class="text-sm font-medium text-gray-700">* Dirección</label>
            <input wire:model="emergency_address" type="text" id="emergency_address" name="emergency_address"
                required class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('emergency_address')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Dirección</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="state_id" class="text-sm font-medium text-gray-700">* Estado</label>
            <select wire:model.live="state_id" id="state_id" name="state_id"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                <option value="">Elije...</option>
                @foreach ($states as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            @error('state_id')
                <div class="bg-red-100 text-red-700 p-2 rounded-lg mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="county_id" class="text-sm font-medium text-gray-700">* Municipio</label>
            <select wire:model="county_id" id="county_id" name="county_id"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200" required>
                <option value="">Elije...</option>
                @foreach ($counties as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            @error('county_id')
                <div class="bg-red-100 text-red-700 p-2 rounded-lg mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="neighborhood" class="text-sm font-medium text-gray-700">* Colonia</label>
            <input wire:model="neighborhood" type="text" id="neighborhood" name="neighborhood" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('neighborhood')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="roadway_type" class="text-sm font-medium text-gray-700">* Tipo de Vialidad</label>
            <input wire:model="roadway_type" type="text" id="roadway_type" name="roadway_type" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('roadway_type')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="street" class="text-sm font-medium text-gray-700">* Nombre de Vialidad (Calle)</label>
            <input wire:model="street" type="text" id="street" name="street" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('street')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/6">
            <label for="outdoor_number" class="text-sm font-medium text-gray-700">* No. de Exterior</label>
            <input wire:model="outdoor_number" type="text" id="outdoor_number" name="outdoor_number" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('outdoor_number')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/6">
            <label for="interior_number" class="text-sm font-medium text-gray-700">No. de Interior</label>
            <input wire:model="interior_number" type="text" id="interior_number" name="interior_number"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('interior_number')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/6">
            <label for="cp" class="text-sm font-medium text-gray-700">* CP</label>
            <input wire:model="cp" type="text" id="cp" name="cp" placeholder="Ej. 29000" required
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('cp')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="locality" class="text-sm font-medium text-gray-700">Localidad</label>
            <input wire:model="locality" type="text" id="locality" name="locality"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('locality')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Datos Bancarios</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="account_number" class="text-sm font-medium text-gray-700">No. de Cuenta</label>
            <input wire:model="account_number" type="text" id="account_number" name="account_number"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('account_number')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="clabe" class="text-sm font-medium text-gray-700">CLABE</label>
            <input wire:model="clabe" type="text" id="clabe" name="clabe"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('clabe')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/4">
            <label for="bank_id" class="text-sm font-medium text-gray-700">Banco</label>
            <select wire:model="bank_id" id="bank_id" name="bank_id"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                @foreach ($banks as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            @error('bank_id')
                <div class="bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-2 rounded-lg mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- <div class="flex flex-col w-full">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Archivos</h2>
        </div>
        <div class="flex flex-col w-full md:w-1/2">
            <label for="photo" class="text-sm font-medium text-gray-700">Fotografía</label>
            @if ($photo)
                <img src="{{ $photo->temporaryUrl() }}">
            @endif
            <input type="file" wire:model ="photo" id="photo" name="photo"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('photo')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="flex flex-col w-full md:w-1/2">
            <label for="signature" class="text-sm font-medium text-gray-700">Firma</label>
            <input wire:model="signature" type="file" id="signature" name="signature"
                accept="image/jpeg,image/jpg"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
            @error('signature')
                <div class="w-full bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-400 p-4 rounded-lg mt-2"
                    role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div> --}}
        <div class="w-full flex justify-end gap-3 m-4">
            <a href="{{ route('employees.index') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>
    </form>
</div>

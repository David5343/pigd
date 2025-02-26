<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <div class="relative flex mt-3 mb-3 w-1/5">
        <input type="search"
            class="relative m-0 -me-0.5 block flex-auto rounded-s border border-solid border-neutral-200 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-surface outline-none transition duration-200 ease-in-out placeholder:text-neutral-500 focus:z-[3] focus:border-primary focus:shadow-inset focus:outline-none motion-reduce:transition-none dark:border-white/10 dark:text-white dark:placeholder:text-neutral-200 dark:autofill:shadow-autofill dark:focus:border-primary"
            placeholder="Ingresa el folio..." aria-label="Search" id="exampleFormControlInput3"
            aria-describedby="button-addon3" />
        <button
            class="z-[2] inline-block rounded-e border-2 border-primary px-6 pb-[6px] pt-2 text-xs font-medium uppercase leading-normal text-primary transition duration-150 ease-in-out hover:border-primary-accent-300 hover:bg-primary-50/50 hover:text-primary-accent-300 focus:border-primary-600 focus:bg-primary-50/50 focus:text-primary-600 focus:outline-none focus:ring-0 active:border-primary-700 active:text-primary-700 dark:text-primary-500 dark:hover:bg-blue-950 dark:focus:bg-blue-950"
            data-twe-ripple-init data-twe-ripple-color="white" type="button" id="button-addon3">
            Buscar
        </button>
    </div>
    <div class="flex flex-col w-full md:w-32">
        <label for="nombre" class="text-sm font-medium text-gray-700">Folio</label>
        <input type="text" id="file_number_insured" name="file_number_insured"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200 bg-gray-300" disabled>
    </div>
    <div class="flex flex-col w-full md:w-1/3">
        <label for="nombre" class="text-sm font-medium text-gray-700">Nombre</label>
        <input wire:model="name_insured" type="text" id="name_insured" name="name_insured"
            class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200 bg-gray-300" disabled>
        <input type="hidden" id="insured_id" name="insured_id">
    </div>
    <h2 class="text-xl font-bold text-gray-700 mb-4 mt-4">Datos Generales</h2>
    <h5 class="text-base font-bold text-gray-700 mb-4">(*) Campos Obligatorios.</h5>
    <form wire:submit ="guardar" class="flex flex-wrap gap-2">

        <div class="flex flex-col w-full md:w-32">
            <label for="nombre" class="text-sm font-medium text-gray-700">* Folio</label>
            <input type="text" id="file_number" name="file_number"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200 bg-gray-300"
                value="{{ $folio }}" disabled>
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="fecha" class="text-sm font-medium text-gray-700">* Fecha de Ingreso</label>
            <input wire:model="start_date" type="date" id="start_date" name="start_date"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>

        <div class="flex flex-col w-full md:w-1/3">
            <label for="nombre" class="text-sm font-medium text-gray-700">* Apellido Paterno (Primer Apellido)</label>
            <input wire:model="last_name_1" type="text" id="last_name_1" name="last_name_1"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="nombre" class="text-sm font-medium text-gray-700">Apellido Materno (Segundo Apellido)</label>
            <input wire:model="last_name_2" type="text" id="last_name_2" name="last_name_2"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="nombre" class="text-sm font-medium text-gray-700">* Nombre</label>
            <input wire:model="name" type="text" id="name" name="name"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="fecha" class="text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
            <input wire:model="birthday" type="date" id="birthday" name="birthday"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <!-- Radio Buttons (50% de ancho) -->
        <fieldset class="flex flex-col w-full md:w-32">
            <legend class="text-sm font-medium text-gray-700">Sexo</legend>
            <div class="flex items-center gap-2">
                <input type="radio" name="sex" id="male" class="focus:ring focus:ring-blue-200">
                <label for="masculino">Masculino</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="sex" id="female" class="focus:ring focus:ring-blue-200">
                <label for="femenino">Femenino</label>
            </div>
        </fieldset>
        <div class="flex flex-col w-full md:w-1/3">
            <label for="nombre" class="text-sm font-medium text-gray-700">CURP</label>
            <input type="text" id="curp" name="curp"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <fieldset class="flex flex-col w-full md:w-1/5">
            <legend class="text-sm font-medium text-gray-700">* ¿Con Diversas Capacidades?</legend>
            <div class="flex items-center gap-2">
                <input type="radio" name="disabled_person" id="yes" class="focus:ring focus:ring-blue-200">
                <label for="masculino">SI</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="radio" name="disabled_person" id="no" class="focus:ring focus:ring-blue-200">
                <label for="femenino">NO</label>
            </div>
        </fieldset>
        <div class="flex flex-col w-full md:w-1/5">
            <label for="opcion" class="text-sm font-medium text-gray-700">* Parentesco</label>
            <select wire:model="relationship" id="relationship" name="relationship"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
                <option selected value="">Elije...</option>
                <option>Padre</option>
                <option>Madre</option>
                <option>Esposa</option>
                <option>Hijo/a</option>
                <option>Concubina</option>
            </select>
        </div>
        <div class="flex flex-col w-full md:w-3/4">
            <label for="nombre" class="text-sm font-medium text-gray-700">Direccion</label>
            <input wire:model="address" type="text" id="address" name="address"
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200">
        </div>
        <div class="flex flex-col w-full">
            <label for="mensaje" class="text-sm font-medium text-gray-700">Observaciones</label>
            <textarea wire:model="observations" id="observations" name="observations" rows="3" minlength="5"
                maxlength="180" placeholder="Observaciones..."
                class="border rounded-lg px-3 py-2 w-full focus:ring focus:ring-blue-200"></textarea>
        </div>
        <!-- Botones alineados a la derecha -->
        <div class="w-full flex justify-end gap-3 mt-4">
            <button type="reset"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Cancelar</button>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Enviar</button>
        </div>

    </form>
</div>

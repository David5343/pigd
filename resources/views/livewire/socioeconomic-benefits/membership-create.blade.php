<div class="w-full bg-white p-4 sm:p-6">
    @session('msg_busqueda')
        <div class="p-4" x-data="{ show: true }">
            <div x-show="show" x-transition
                class="inline-flex w-full items-center rounded-lg bg-yellow-100 px-6 py-5 text-base text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300"
                role="alert">
                <span class="me-2 h-6 w-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <p>
                    <strong>PIGD ¡Atención!</strong> {{ $value }}
                </p>
                <button @click="show = false" type="button"
                    class="ms-auto box-content rounded-md border-none p-1 text-black opacity-50 hover:opacity-75 focus:outline-none dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endsession
    @session('msg')
        <div class="p-4" x-data="{ show: true }">
            <div x-show="show" x-transition
                class="inline-flex w-full items-center rounded-lg bg-green-100 px-6 py-5 text-base text-green-800 dark:bg-green-900 dark:text-green-300"
                role="alert">
                <span class="me-2 h-6 w-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <p>
                    <strong>PIGD ¡Atención!</strong> {{ $value }}
                </p>
                <button @click="show = false" type="button"
                    class="ms-auto box-content rounded-md border-none p-1 text-black opacity-50 hover:opacity-75 focus:outline-none dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endsession
    @session('msg_warning')
        <div class="p-4" x-data="{ show: true }">
            <div x-show="show" x-transition
                class="inline-flex w-full items-center rounded-lg bg-red-100 px-6 py-5 text-base text-red-800 dark:bg-red-900 dark:text-red-300"
                role="alert">
                <span class="me-2 h-6 w-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <p>
                    <strong>PIGD ¡Atención!</strong> {{ $value }}
                </p>
                <button @click="show = false" type="button"
                    class="ms-auto box-content rounded-md border-none p-1 text-black opacity-50 hover:opacity-75 focus:outline-none dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endsession
    <h2 class="mb-4 border-b border-[#E7DFD9] pb-2 text-xl font-semibold text-[#651F34]">Datos Generales</h2>
    <h5 class="mb-4 text-sm font-medium text-slate-600">(*) Campos Obligatorios.</h5>
    <form wire:submit="guardar" class="flex flex-wrap items-start gap-3">
        @if ($errors->any())
            <div class="w-full basis-full rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                <p class="font-semibold">Revisa los siguientes campos:</p>
                <ul class="mt-1 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex min-w-0 basis-[7rem] grow-0 flex-col">
            <label for="file_number_preview" class="text-sm font-medium text-gray-700">Folio</label>
            <input type="text" id="file_number_preview" value="Al guardar"
                class="w-full cursor-not-allowed rounded-lg border border-[#D9CBC5] bg-[#F7F3EC] px-3 py-2 text-slate-600"
                aria-describedby="file-number-help" disabled>
            <span id="file-number-help" class="sr-only">El folio se asigna de forma segura al guardar el registro.</span>
        </div>
        <div class="flex min-w-0 basis-[10rem] grow-0 flex-col">
            <label for="employee_number" class="text-sm font-medium text-gray-700">* Número de empleado</label>
            <input wire:model="employee_number" type="text" id="employee_number" name="employee_number"
                inputmode="numeric" pattern="[0-9]*" maxlength="6" required
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="employee_number" class="mt-1" />
        </div>
        <div class="flex min-w-0 basis-[19rem] grow-0 flex-col">
            <label for="dependency_id" class="text-sm font-medium text-gray-700">* Dependencia</label>
            <select wire:model.live="dependency_id" id="dependency_id" name="dependency_id" required
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                <option value="">Elige una dependencia...</option>
                @foreach ($selectDependencies as $dependency)
                    <option value="{{ $dependency->id }}">{{ $dependency->name }}</option>
                @endforeach
            </select>
            <x-input-error for="dependency_id" class="mt-1" />
        </div>
        <div class="flex min-w-0 basis-[37rem] grow-0 flex-col">
            <label for="subdependency_id" class="text-sm font-medium text-gray-700">* Subdependencia</label>
            <select wire:key="subdependency-select-{{ $dependency_id ?? 'none' }}"
                wire:model="subdependency_id" id="subdependency_id" name="subdependency_id" required
                @disabled(blank($dependency_id))
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20 disabled:cursor-not-allowed disabled:bg-[#F7F3EC]">
                <option value="">
                    @if (blank($dependency_id))
                        Primero elige una dependencia...
                    @elseif ($selectSubdependencies->isEmpty())
                        No hay subdependencias activas...
                    @else
                        Elige una subdependencia...
                    @endif
                </option>
                @foreach ($selectSubdependencies as $subdependency)
                    <option value="{{ $subdependency->id }}">{{ $subdependency->name }}</option>
                @endforeach
            </select>
            <x-input-error for="subdependency_id" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-[17rem]  flex-col">
            <label for="opcion" class="text-sm font-medium text-gray-700">* Categoria</label>
            <select wire:model="rank_id" id="rank_id" name="rank_id" value="{{ old('rank_id') }}" required
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                <option selected value="">Elije...</option>
                @foreach ($select5 as $sd)
                    <option value="{{ $sd->id }}">{{ $sd->name }}</option>
                @endforeach
            </select>
            <x-input-error for="rank_id" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-[8rem] flex-col">
            <label for="start_date" class="text-sm font-medium text-gray-700">* Fecha de ingreso</label>
            <input wire:model="start_date" type="date" id="start_date" name="start_date"
                min="1980-01-01" required
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="start_date" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-[20rem] flex-col">
            <label for="workplace_state_id" class="text-sm font-medium text-gray-700">Estado del lugar de trabajo</label>
            <select wire:model.live="workplace_state_id" id="workplace_state_id" name="workplace_state_id"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                <option value="">Elige una entidad...</option>
                @foreach ($selectStates as $stateOption)
                    <option value="{{ $stateOption->id }}">{{ $stateOption->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex min-w-0 grow basis-[20rem] flex-col">
            <label for="workplace_county_id" class="text-sm font-medium text-gray-700">Municipio del lugar de trabajo</label>
            <select wire:model="workplace_county_id" id="workplace_county_id" name="workplace_county_id"
                @disabled(blank($workplace_state_id))
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20 disabled:cursor-not-allowed disabled:bg-[#F7F3EC]">
                <option value="">Elige un municipio...</option>
                @foreach ($workplaceCounties as $countyOption)
                    <option value="{{ $countyOption->id }}">{{ $countyOption->name }}</option>
                @endforeach
            </select>
            <x-input-error for="workplace_county_id" class="mt-1" />
        </div>
        <div class="flex min-w-0 basis-[8rem] grow-0 flex-col">
            <label for="affiliation_status_id" class="text-sm font-medium text-gray-700">Estatus de afiliación</label>
            <select wire:model="affiliation_status_id" id="affiliation_status_id" name="affiliation_status_id"
                disabled aria-disabled="true"
                class="w-full cursor-not-allowed rounded-lg border border-[#D9CBC5] bg-[#F7F3EC] px-3 py-2 text-slate-600">
                <option value="">Elige...</option>
                @foreach ($selectAffiliationStatuses as $affiliationStatus)
                    <option value="{{ $affiliationStatus->id }}">{{ $affiliationStatus->name }}</option>
                @endforeach
            </select>
            <x-input-error for="affiliation_status_id" class="mt-1" />
        </div>
        <div class="flex w-full basis-full flex-col">
            <label for="mensaje" class="text-sm font-medium text-gray-700">Motivo de alta</label>
            <textarea wire:model="register_motive" id="register_motive" name="register_motive" rows="4"
                placeholder="Se da de alta registro con oficio no. 456879 (Si aplica)..." minlength="3" maxlength="120"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20"></textarea>
            <x-input-error for="register_motive" class="mt-1" />
        </div>
        <div class="flex w-full basis-full flex-col">
            <label for="mensaje" class="text-sm font-medium text-gray-700">Observaciones</label>
            <textarea wire:model="observations" id="observations" name="observations" rows="4" minlength="5"
                maxlength="180" placeholder="Observaciones..."
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20"></textarea>
            <x-input-error for="observations" class="mt-1" />
        </div>
        <div class="flex w-full basis-full flex-col">
            <h2 class="mb-4 border-b border-[#E7DFD9] pb-2 text-xl font-semibold text-[#651F34]">Datos Personales</h2>
        </div>
        <div class="flex min-w-0 grow basis-[14rem] flex-col">
            <label for="last_name_1" class="text-sm font-medium text-gray-700">Apellido paterno (primer apellido)</label>
            <input wire:model="last_name_1" type="text" id="last_name_1" name="last_name_1" maxlength="20"
                @disabled($sin_apellido_paterno) @required(! $sin_apellido_paterno)
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="last_name_1" class="mt-1" />
            <label for="sin_apellido_paterno" class="mt-1 flex items-center gap-2 text-xs text-slate-600">
                <input wire:model.live="sin_apellido_paterno" type="checkbox" id="sin_apellido_paterno"
                    class="rounded border-[#D9CBC5] text-[#651F34] focus:ring-[#651F34]/20">
                Sin apellido paterno
            </label>
        </div>
        <div class="flex min-w-0 grow basis-[14rem] flex-col">
            <label for="last_name_2" class="text-sm font-medium text-gray-700">Apellido materno (segundo apellido)</label>
            <input wire:model="last_name_2" type="text" id="last_name_2" name="last_name_2" maxlength="20"
                @disabled($sin_apellido_materno) @required(! $sin_apellido_materno)
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="last_name_2" class="mt-1" />
            <label for="sin_apellido_materno" class="mt-1 flex items-center gap-2 text-xs text-slate-600">
                <input wire:model.live="sin_apellido_materno" type="checkbox" id="sin_apellido_materno"
                    class="rounded border-[#D9CBC5] text-[#651F34] focus:ring-[#651F34]/20">
                Sin apellido materno
            </label>
        </div>
        <div class="flex min-w-0 grow basis-[14rem] flex-col">
            <label for="name" class="text-sm font-medium text-gray-700">* Nombre</label>
            <input wire:model="name" type="text" id="name" name="name" required
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="name" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-[8rem] flex-col">
            <label for="opcion" class="text-sm font-medium text-gray-700">* Tipo de Sangre</label>
            <select wire:model="blood_type" id="blood_type" name="blood_type" required
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                <option selected value="">Elije...</option>
                <option>A+</option>
                <option>A-</option>
                <option>B+</option>
                <option>B-</option>
                <option>AB+</option>
                <option>AB-</option>
                <option>O+</option>
                <option>O-</option>
            </select>
            <x-input-error for="blood_type" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-[9rem] flex-col">
            <label for="birthday" class="text-sm font-medium text-gray-700">* Fecha de nacimiento</label>
            <input wire:model="birthday" type="date" id="birthday" name="birthday" required
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="birthday" class="mt-1" />
            <p class="mt-1 text-xs text-slate-500">Edad mínima para el registro: 18 años.</p>
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="birthplace_state_id" class="text-sm font-medium text-gray-700">Estado de nacimiento</label>
            <select wire:model.live="birthplace_state_id" id="birthplace_state_id" name="birthplace_state_id"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                <option value="">Elige una entidad...</option>
                @foreach ($selectStates as $stateOption)
                    <option value="{{ $stateOption->id }}">{{ $stateOption->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="birthplace_county_id" class="text-sm font-medium text-gray-700">Municipio de nacimiento</label>
            <select wire:model="birthplace_county_id" id="birthplace_county_id" name="birthplace_county_id"
                @disabled(blank($birthplace_state_id))
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20 disabled:cursor-not-allowed disabled:bg-[#F7F3EC]">
                <option value="">Elige un municipio...</option>
                @foreach ($birthplaceCounties as $countyOption)
                    <option value="{{ $countyOption->id }}">{{ $countyOption->name }}</option>
                @endforeach
            </select>
            <x-input-error for="birthplace_county_id" class="mt-1" />
        </div>
        <!-- Radio Buttons (50% de ancho) -->
        <fieldset class="flex min-w-0 grow basis-56 flex-col">
            <legend class="text-sm font-medium text-gray-700">* Sexo</legend>
            <div class="flex items-center gap-2">
                <input wire:model="sex" type="radio" name="sex" id="male" value="Hombre" required
                    class="accent-[#651F34] focus:ring-2 focus:ring-[#651F34]/20">
                <label for="male">Hombre</label>
            </div>
            <div class="flex items-center gap-2">
                <input wire:model="sex" type="radio" name="sex" id="female" value="Mujer" required
                    class="accent-[#651F34] focus:ring-2 focus:ring-[#651F34]/20">
                <label for="female">Mujer</label>
            </div>
            <x-input-error for="sex" class="mt-1" />
        </fieldset>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="opcion" class="text-sm font-medium text-gray-700">Estado Civil</label>
            <select wire:model="marital_status" id="marital_status" name="marital_status"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                <option selected value="">Elije...</option>
                <option>Soltero/a</option>
                <option>Casado/a</option>
                <option>Divorciado/a</option>
                <option>Separado/a en proceso Judicial</option>
                <option>Viudo/a</option>
                <option>Union Libre</option>
                <option>Concubinato</option>
            </select>
            <x-input-error for="marital_status" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="nombre" class="text-sm font-medium text-gray-700">* RFC</label>
            <input wire:model="rfc" type="text" id="rfc" name="rfc" maxlength="13"
                pattern="[A-Za-z0-9]{13}" title="Captura exactamente 13 letras o números." required
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="rfc" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="nombre" class="text-sm font-medium text-gray-700">CURP</label>
            <input wire:model="curp" type="text" id="curp" name="curp" maxlength="18"
                pattern="[A-Za-z0-9]{18}" title="Si capturas la CURP, debe tener exactamente 18 letras o números."
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="curp" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="phone" class="text-sm font-medium text-gray-700">Teléfono (10 dígitos)</label>
            <input wire:model="phone" type="tel" id="phone" name="phone" inputmode="numeric"
                pattern="[0-9]{10}" minlength="10" maxlength="10" autocomplete="tel-national"
                placeholder="Ej. 9611234567" title="Ingresa 10 dígitos, sin código de país"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="phone" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="email" class="text-sm font-medium text-gray-700">Correo electrónico</label>
            <input wire:model="email" type="email" id="email" placeholder="correo@ejemplo.com"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="email" class="mt-1" />
        </div>
        <div class="flex w-full basis-full flex-col">
            <h2 class="mb-4 border-b border-[#E7DFD9] pb-2 text-xl font-semibold text-[#651F34]">Dirección</h2>
        </div>
        <div class="flex min-w-0 basis-[15rem] grow-0 flex-col">
            <label for="state_id" class="text-sm font-medium text-gray-700">Entidad federativa del domicilio</label>
            <select wire:model.live="state_id" id="state_id" name="state_id"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                <option value="">Elige una entidad...</option>
                @foreach ($selectStates as $stateOption)
                    <option value="{{ $stateOption->id }}">{{ $stateOption->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex min-w-0 basis-[15rem] grow-0 flex-col">
            <label for="county_id" class="text-sm font-medium text-gray-700">Municipio del domicilio</label>
            <select wire:model="county_id" id="county_id" name="county_id"
                @disabled(blank($state_id))
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                <option value="">Elige un municipio...</option>
                @foreach ($addressCounties as $countyOption)
                    <option value="{{ $countyOption->id }}">{{ $countyOption->name }}</option>
                @endforeach
            </select>
            <x-input-error for="county_id" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="nombre" class="text-sm font-medium text-gray-700">Colonia</label>
            <input wire:model="neighborhood" type="text" id="neighborhood" name="neighborhood"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="neighborhood" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="nombre" class="text-sm font-medium text-gray-700">Tipo de Vialidad</label>
            <input wire:model="roadway_type" type="text" id="roadway_type" name="roadway_type"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="roadway_type" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="nombre" class="text-sm font-medium text-gray-700">Nombre de Vialidad (Calle)</label>
            <input wire:model="street" type="text" id="street" name="street"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="street" class="mt-1" />
        </div>
        <div class="flex min-w-0 basis-[7rem] grow-0 flex-col">
            <label for="nombre" class="text-sm font-medium text-gray-700">No. de Exterior</label>
            <input wire:model="outdoor_number" type="text" id="outdoor_number" name="outdoor_number"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="outdoor_number" class="mt-1" />
        </div>
        <div class="flex min-w-0 basis-[7rem] grow-0 flex-col">
            <label for="nombre" class="text-sm font-medium text-gray-700">No. de Interior</label>
            <input wire:model="interior_number" type="text" id="interior_number" name="interior_number"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="interior_number" class="mt-1" />
        </div>
        <div class="flex min-w-0 basis-[7rem] grow-0 flex-col">
            <label for="nombre" class="text-sm font-medium text-gray-700">CP</label>
            <input wire:model="cp" type="text" id="cp" name="cp"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="cp" class="mt-1" />
        </div>
        <div class="flex min-w-0 grow basis-56 flex-col">
            <label for="nombre" class="text-sm font-medium text-gray-700">Localidad</label>
            <input wire:model="locality" type="text" id="locality" name="locality"
                class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-gray-900 transition focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
            <x-input-error for="locality" class="mt-1" />
        </div>
        {{-- <fieldset class="flex min-w-0 grow basis-56 flex-col">
            <legend class="text-sm font-medium text-gray-700">Preferencias</legend>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="notificaciones" class="accent-[#651F34] focus:ring-2 focus:ring-[#651F34]/20">
                <label for="notificaciones">Recibir notificaciones</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="ofertas" class="accent-[#651F34] focus:ring-2 focus:ring-[#651F34]/20">
                <label for="ofertas">Recibir ofertas</label>
            </div>
        </fieldset> --}}
        <!-- Botones alineados a la derecha -->
        <div class="flex w-full basis-full justify-end gap-3 pt-2">
            @if ($inModal)
                <button type="button" wire:click="cerrarModal"
                    class="rounded-lg border border-[#E7DFD9] bg-white px-4 py-2 text-sm font-medium text-[#651F34] transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                    Cancelar
                </button>
            @else
                <a href="{{ route('membership.index') }}"
                    class="rounded-lg border border-[#E7DFD9] bg-white px-4 py-2 text-sm font-medium text-[#651F34] transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                    Cancelar
                </a>
            @endif
            <button type="submit"
                class="rounded-lg bg-[#651F34] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2">Guardar titular</button>
        </div>

    </form>
</div>

<div>
    @if ($isOpen)
        <div wire:click.self="close" wire:keydown.escape.window="close" x-cloak
            role="dialog" aria-modal="true" aria-labelledby="beneficiary-create-title"
            class="fixed inset-0 z-[120] flex items-center justify-center bg-black/50 p-3 sm:p-6">
            <section
                class="flex max-h-[90vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl border border-[#E7DFD9] bg-white shadow-2xl">
                <header class="flex shrink-0 items-center justify-between gap-4 border-b border-[#E7DFD9] bg-[#F7F3EC] px-4 py-3 sm:px-6">
                    <div class="min-w-0">
                        <h2 id="beneficiary-create-title" class="font-semibold text-[#651F34]">
                            Nuevo familiar
                        </h2>
                        <p class="mt-1 text-xs text-slate-600">
                            Selecciona un titular activo para asociar el registro.
                        </p>
                    </div>
                    <button type="button" wire:click="close" aria-label="Cerrar formulario de familiar"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18" />
                        </svg>
                    </button>
                </header>

                <div class="min-h-0 flex-1 overflow-y-auto p-4 sm:p-6">
                    <div class="space-y-6">
    <section class="overflow-hidden rounded-xl border border-[#E7DFD9] bg-white shadow-sm">
        <div class="border-b border-[#E7DFD9] bg-[#F7F3EC] px-4 py-4 sm:px-6">
            <h2 class="font-semibold text-[#651F34]">Titular al que se vinculará el familiar</h2>
            <p class="mt-1 text-sm text-slate-600">
                Busca por folio, nombre, apellidos o RFC y selecciona al titular activo.
            </p>
        </div>

        <div class="space-y-4 p-4 sm:p-6">
            @if ($selectedInsured)
                <div class="flex flex-col justify-between gap-3 rounded-lg border border-green-200 bg-green-50 p-4 sm:flex-row sm:items-center">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-green-800">Titular seleccionado</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $selectedInsured['name'] ?: 'Nombre no disponible' }}</p>
                        <p class="mt-1 text-sm text-slate-600">
                            Folio {{ $selectedInsured['file_number'] ?: 'no disponible' }}
                            @if ($selectedInsured['rfc'])
                                <span class="mx-1 text-slate-400">·</span> RFC {{ $selectedInsured['rfc'] }}
                            @endif
                        </p>
                    </div>
                    <button type="button" wire:click="clearInsuredSelection"
                        class="self-start rounded-lg border border-green-300 bg-white px-3 py-2 text-sm font-medium text-green-900 transition hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-700 sm:self-center">
                        Cambiar titular
                    </button>
                </div>
            @else
                <div>
                    <label for="insured-search-for-beneficiary" class="mb-1 block text-sm font-medium text-slate-700">
                        Buscar titular
                    </label>
                    <input id="insured-search-for-beneficiary" type="search"
                        wire:model.live.debounce.300ms="insuredSearch"
                        autocomplete="off"
                        placeholder="Ej. folio, nombre, apellidos o RFC"
                        class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2.5 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                    <p class="mt-1 text-xs text-slate-500">
                        Escribe al menos dos caracteres para ver titulares activos.
                    </p>

                    @error('insuredId')
                        <p class="mt-2 text-sm text-red-700" role="alert">{{ $message }}</p>
                    @enderror

                    @if (mb_strlen(trim($insuredSearch)) >= 2)
                        <div class="mt-3 overflow-hidden rounded-lg border border-[#E7DFD9]">
                            @forelse ($insuredOptions as $insuredOption)
                                @php
                                    $nombreTitular = collect([
                                        $insuredOption->last_name_1,
                                        $insuredOption->last_name_2,
                                        $insuredOption->name,
                                    ])->filter(fn ($parte) => filled($parte))->implode(' ');
                                @endphp
                                <button type="button"
                                    wire:key="insured-search-option-{{ $insuredOption->id }}"
                                    wire:click="selectInsured({{ $insuredOption->id }})"
                                    class="flex w-full flex-col gap-1 border-b border-[#E7DFD9] px-4 py-3 text-left transition last:border-b-0 hover:bg-[#F7F3EC] focus:bg-[#F7F3EC] focus:outline-none">
                                    <span class="font-medium text-[#651F34]">
                                        {{ $nombreTitular ?: 'Nombre no disponible' }}
                                    </span>
                                    <span class="text-xs text-slate-600">
                                        Folio {{ $insuredOption->file_number ?: 'no disponible' }}
                                        @if ($insuredOption->rfc)
                                            <span class="mx-1 text-slate-400">·</span> RFC {{ $insuredOption->rfc }}
                                        @endif
                                    </span>
                                </button>
                            @empty
                                <p class="px-4 py-3 text-sm text-slate-600">
                                    No se encontraron titulares activos con esos datos.
                                </p>
                            @endforelse
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    @if ($createError)
        <p class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
            {{ $createError }}
        </p>
    @endif

        <section class="overflow-hidden rounded-xl border border-[#E7DFD9] bg-white shadow-sm">
            <div class="border-b border-[#E7DFD9] bg-[#F7F3EC] px-4 py-4 sm:px-6">
                <h2 class="font-semibold text-[#651F34]">Datos del nuevo familiar</h2>
                @if ($selectedInsured)
                    <p class="mt-1 text-sm text-slate-600">
                        Los campos marcados con <span class="font-semibold text-red-600">*</span> son obligatorios.
                    </p>
                @else
                    <p class="mt-1 text-sm text-slate-600">
                        Selecciona primero un titular activo; los campos se habilitarán al elegirlo.
                    </p>
                @endif
            </div>

            <form wire:submit="saveFamily" class="space-y-5 p-4 sm:p-6">
                @if ($errors->any())
                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                        <p class="font-semibold">Revisa los datos del formulario:</p>
                        <ul class="mt-1 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <fieldset @disabled(! $selectedInsured)
                    class="grid grid-cols-1 gap-4 disabled:opacity-60 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="col-span-1">
                        <label for="family-file-number" class="mb-1 block text-sm font-medium text-slate-700">
                            Folio
                        </label>
                        <input id="family-file-number" type="text" wire:model="file_number" disabled
                            class="w-full rounded-lg border border-[#D9CBC5] bg-slate-100 px-3 py-2 text-sm text-slate-600">
                    </div>
                    <div>
                        <label for="family-start-date" class="mb-1 block text-sm font-medium text-slate-700">
                            Fecha de ingreso <span class="text-red-600">*</span>
                        </label>
                        <input id="family-start-date" type="date" wire:model="start_date"
                            class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                    </div>
                    <div>
                        <label for="family-last-name-1" class="mb-1 block text-sm font-medium text-slate-700">
                            Primer apellido <span class="text-red-600">*</span>
                        </label>
                        <input id="family-last-name-1" type="text" wire:model="last_name_1" maxlength="20"
                            autocomplete="family-name"
                            class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                    </div>
                    <div>
                        <label for="family-last-name-2" class="mb-1 block text-sm font-medium text-slate-700">
                            Segundo apellido
                        </label>
                        <input id="family-last-name-2" type="text" wire:model="last_name_2" maxlength="20"
                            autocomplete="additional-name"
                            class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                    </div>
                    <div>
                        <label for="family-name" class="mb-1 block text-sm font-medium text-slate-700">
                            Nombre(s) <span class="text-red-600">*</span>
                        </label>
                        <input id="family-name" type="text" wire:model="name" maxlength="30" autocomplete="given-name"
                            class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                    </div>
                    <div>
                        <label for="family-birthday" class="mb-1 block text-sm font-medium text-slate-700">
                            Fecha de nacimiento
                        </label>
                        <input id="family-birthday" type="date" wire:model="birthday"
                            class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                    </div>
                    <div>
                        <label for="family-sex" class="mb-1 block text-sm font-medium text-slate-700">
                            Sexo <span class="text-red-600">*</span>
                        </label>
                        <select id="family-sex" wire:model="sex"
                            class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                            <option value="">Selecciona...</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                        </select>
                    </div>
                    <div>
                        <label for="family-rfc" class="mb-1 block text-sm font-medium text-slate-700">RFC</label>
                        <input id="family-rfc" type="text" wire:model="rfc" maxlength="13" autocomplete="off"
                            class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm uppercase focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                    </div>
                    <div>
                        <label for="family-curp" class="mb-1 block text-sm font-medium text-slate-700">
                            CURP <span class="text-red-600">*</span>
                        </label>
                        <input id="family-curp" type="text" wire:model="curp" maxlength="18" required
                            autocomplete="off"
                            class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm uppercase focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                    </div>
                    <div>
                        <label for="family-relationship" class="mb-1 block text-sm font-medium text-slate-700">
                            Parentesco <span class="text-red-600">*</span>
                        </label>
                        <select id="family-relationship" wire:model="relationship"
                            class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                            <option value="">Selecciona...</option>
                            <option value="Padre">Padre</option>
                            <option value="Madre">Madre</option>
                            <option value="Esposa">Esposa</option>
                            <option value="Hijo">Hijo</option>
                            <option value="Hija">Hija</option>
                            <option value="Concubina">Concubina</option>
                        </select>
                    </div>
                    <fieldset>
                        <legend class="mb-1 block text-sm font-medium text-slate-700">
                            ¿Tiene discapacidad? <span class="text-red-600">*</span>
                        </legend>
                        <div class="flex min-h-10 items-center gap-4">
                            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="family-disabled-person" value="SI"
                                    wire:model="disabled_person"
                                    class="border-slate-300 text-[#651F34] focus:ring-[#651F34]">
                                Sí
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="family-disabled-person" value="NO"
                                    wire:model="disabled_person"
                                    class="border-slate-300 text-[#651F34] focus:ring-[#651F34]">
                                No
                            </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="mb-1 block text-sm font-medium text-slate-700">¿Es estudiante?</legend>
                        <div class="flex min-h-10 items-center gap-4">
                            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="family-is-student" value="SI" wire:model="is_student"
                                    @checked($is_student === 'SI')
                                    class="border-slate-300 text-[#651F34] focus:ring-[#651F34]">
                                Sí
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="family-is-student" value="NO" wire:model="is_student"
                                    @checked($is_student === 'NO')
                                    class="border-slate-300 text-[#651F34] focus:ring-[#651F34]">
                                No
                            </label>
                        </div>
                    </fieldset>
                    <div class="sm:col-span-2 xl:col-span-4">
                        <label for="family-address" class="mb-1 block text-sm font-medium text-slate-700">
                            Domicilio
                        </label>
                        <textarea id="family-address" wire:model="address" rows="3" maxlength="255"
                            autocomplete="street-address"
                            class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                        </textarea>
                    </div>
                    <div class="sm:col-span-2 xl:col-span-4">
                        <label for="family-observations" class="mb-1 block text-sm font-medium text-slate-700">
                            Observaciones
                        </label>
                        <textarea id="family-observations" wire:model="observations" rows="2" maxlength="255"
                            class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20"></textarea>
                    </div>
                </fieldset>

                <footer class="flex flex-col-reverse justify-end gap-2 border-t border-[#E7DFD9] pt-4 sm:flex-row">
                    <button type="button" wire:click="close"
                        class="rounded-lg border border-[#E7DFD9] bg-white px-5 py-2.5 text-center text-sm font-medium text-[#651F34] transition hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2">
                        Cancelar
                    </button>
                    <button type="submit" wire:loading.attr="disabled" wire:target="saveFamily"
                        @disabled(! $selectedInsured)
                        class="rounded-lg bg-[#651F34] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
                        <span wire:loading.remove wire:target="saveFamily">Guardar familiar</span>
                        <span wire:loading wire:target="saveFamily">Guardando...</span>
                    </button>
                </footer>
            </form>
        </section>
</div>
                </div>
            </section>
        </div>
    @endif
</div>

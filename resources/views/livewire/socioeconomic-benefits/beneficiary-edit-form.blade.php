<div>
    @if ($isOpen)
        <div wire:click.self="close" wire:keydown.escape.window="close" x-cloak
            role="dialog" aria-modal="true" aria-labelledby="beneficiary-edit-title"
            class="fixed inset-0 z-[120] flex items-center justify-center bg-black/50 p-3 sm:p-6">
            <section
                class="flex max-h-[90vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl border border-[#E7DFD9] bg-white shadow-2xl">
                <header class="flex shrink-0 items-center justify-between gap-4 border-b border-[#E7DFD9] bg-[#F7F3EC] px-4 py-3 sm:px-6">
                    <div class="min-w-0">
                        <h2 id="beneficiary-edit-title" class="font-semibold text-[#651F34]">
                            Editar familiar
                        </h2>
                        <p class="mt-1 truncate text-xs text-slate-600">
                            {{ $selectedInsured['name'] ?? 'Titular no disponible' }}
                            <span class="mx-1 text-slate-400">·</span>
                            Folio titular {{ $selectedInsured['file_number'] ?? 'no disponible' }}
                        </p>
                    </div>
                    <button type="button" wire:click="close" aria-label="Cerrar edición de familiar"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18" />
                        </svg>
                    </button>
                </header>

                <div class="min-h-0 flex-1 overflow-y-auto p-4 sm:p-6">
                    @if ($saveError)
                        <p class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
                            role="alert">
                            {{ $saveError }}
                        </p>
                    @endif

                    <section class="overflow-hidden rounded-xl border border-[#E7DFD9] bg-white">
                        <div class="border-b border-[#E7DFD9] bg-[#F7F3EC] px-4 py-4 sm:px-6">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="font-semibold text-[#651F34]">Datos del familiar</h3>
                                    <p class="mt-1 text-sm text-slate-600">
                                        Los campos marcados con <span class="font-semibold text-red-600">*</span> son obligatorios.
                                    </p>
                                </div>
                                <div class="rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-sm">
                                    <span class="text-slate-600">Estatus de afiliación:</span>
                                    <span class="ml-1 font-semibold text-green-800">{{ $affiliate_status }}</span>
                                </div>
                            </div>
                        </div>

                        <form wire:submit="saveChanges" class="space-y-5 p-4 sm:p-6">
                            @if ($errors->any())
                                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
                                    role="alert">
                                    <p class="font-semibold">Revisa los datos del formulario:</p>
                                    <ul class="mt-1 list-inside list-disc">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                <div class="col-span-1">
                                    <label for="edit-family-file-number" class="mb-1 block text-sm font-medium text-slate-700">
                                        Folio
                                    </label>
                                    <input id="edit-family-file-number" type="text" wire:model="file_number" disabled
                                        class="w-full rounded-lg border border-[#D9CBC5] bg-slate-100 px-3 py-2 text-sm text-slate-600">
                                </div>
                                <div>
                                    <label for="edit-family-start-date" class="mb-1 block text-sm font-medium text-slate-700">
                                        Fecha de ingreso <span class="text-red-600">*</span>
                                    </label>
                                    <input id="edit-family-start-date" type="date" wire:model="start_date"
                                        class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                                </div>
                                <div>
                                    <label for="edit-family-last-name-1" class="mb-1 block text-sm font-medium text-slate-700">
                                        Primer apellido <span class="text-red-600">*</span>
                                    </label>
                                    <input id="edit-family-last-name-1" type="text" wire:model="last_name_1"
                                        maxlength="20" autocomplete="family-name"
                                        class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                                </div>
                                <div>
                                    <label for="edit-family-last-name-2" class="mb-1 block text-sm font-medium text-slate-700">
                                        Segundo apellido
                                    </label>
                                    <input id="edit-family-last-name-2" type="text" wire:model="last_name_2"
                                        maxlength="20" autocomplete="additional-name"
                                        class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                                </div>
                                <div>
                                    <label for="edit-family-name" class="mb-1 block text-sm font-medium text-slate-700">
                                        Nombre(s) <span class="text-red-600">*</span>
                                    </label>
                                    <input id="edit-family-name" type="text" wire:model="name" maxlength="30"
                                        autocomplete="given-name"
                                        class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                                </div>
                                <div>
                                    <label for="edit-family-birthday" class="mb-1 block text-sm font-medium text-slate-700">
                                        Fecha de nacimiento
                                    </label>
                                    <input id="edit-family-birthday" type="date" wire:model="birthday"
                                        class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                                </div>
                                <div>
                                    <label for="edit-family-sex" class="mb-1 block text-sm font-medium text-slate-700">
                                        Sexo <span class="text-red-600">*</span>
                                    </label>
                                    <select id="edit-family-sex" wire:model="sex"
                                        class="w-full rounded-lg border border-[#D9CBC5] bg-white px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                                        <option value="">Selecciona...</option>
                                        <option value="Hombre">Hombre</option>
                                        <option value="Mujer">Mujer</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="edit-family-rfc" class="mb-1 block text-sm font-medium text-slate-700">
                                        RFC
                                    </label>
                                    <input id="edit-family-rfc" type="text" wire:model="rfc" maxlength="13"
                                        autocomplete="off"
                                        class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm uppercase focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                                </div>
                                <div>
                                    <label for="edit-family-curp" class="mb-1 block text-sm font-medium text-slate-700">
                                        CURP <span class="text-red-600">*</span>
                                    </label>
                                    <input id="edit-family-curp" type="text" wire:model="curp" maxlength="18" required
                                        autocomplete="off"
                                        class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm uppercase focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                                </div>
                                <div>
                                    <label for="edit-family-relationship" class="mb-1 block text-sm font-medium text-slate-700">
                                        Parentesco <span class="text-red-600">*</span>
                                    </label>
                                    <select id="edit-family-relationship" wire:model="relationship"
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
                                            <input type="radio" name="edit-family-disabled-person" value="SI"
                                                wire:model="disabled_person"
                                                class="border-slate-300 text-[#651F34] focus:ring-[#651F34]">
                                            Sí
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                            <input type="radio" name="edit-family-disabled-person" value="NO"
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
                                            <input type="radio" name="edit-family-is-student" value="SI"
                                                wire:model="is_student" @checked($is_student === 'SI')
                                                class="border-slate-300 text-[#651F34] focus:ring-[#651F34]">
                                            Sí
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                            <input type="radio" name="edit-family-is-student" value="NO"
                                                wire:model="is_student" @checked($is_student === 'NO')
                                                class="border-slate-300 text-[#651F34] focus:ring-[#651F34]">
                                            No
                                        </label>
                                    </div>
                                </fieldset>
                                <div class="sm:col-span-2 xl:col-span-4">
                                    <label for="edit-family-address" class="mb-1 block text-sm font-medium text-slate-700">
                                        Domicilio
                                    </label>
                                    <textarea id="edit-family-address" wire:model="address" rows="3" maxlength="255"
                                        class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20"></textarea>
                                </div>
                                <div class="sm:col-span-2 xl:col-span-4">
                                    <label for="edit-family-observations" class="mb-1 block text-sm font-medium text-slate-700">
                                        Observaciones
                                    </label>
                                    <textarea id="edit-family-observations" wire:model="observations" rows="2"
                                        maxlength="255"
                                        class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20"></textarea>
                                </div>
                            </div>

                            <footer class="flex flex-col-reverse justify-end gap-2 border-t border-[#E7DFD9] pt-4 sm:flex-row">
                                <button type="button" wire:click="close"
                                    class="rounded-lg border border-[#E7DFD9] bg-white px-5 py-2.5 text-center text-sm font-medium text-[#651F34] transition hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2">
                                    Cancelar
                                </button>
                                <button type="submit" wire:loading.attr="disabled" wire:target="saveChanges"
                                    class="rounded-lg bg-[#651F34] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
                                    <span wire:loading.remove wire:target="saveChanges">Guardar cambios</span>
                                    <span wire:loading wire:target="saveChanges">Guardando...</span>
                                </button>
                            </footer>
                        </form>
                    </section>
                </div>
            </section>
        </div>
    @endif
</div>

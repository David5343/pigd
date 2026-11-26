<div>
    @if ($isOpen && $familiar)
        <div wire:click.self="close"
            role="dialog" aria-modal="true" aria-labelledby="beneficiary-credential-create-title"
            class="fixed inset-0 z-[110] flex items-center justify-center bg-black/35 p-3 sm:p-6">
            <section class="flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded-2xl border border-[#E7DFD9] bg-white shadow-2xl">
                <header class="flex shrink-0 items-center justify-between gap-4 border-b border-[#E7DFD9] bg-[#F7F3EC] px-4 py-4 sm:px-6">
                    <div class="min-w-0">
                        <h2 id="beneficiary-credential-create-title" class="font-semibold text-[#651F34]">
                            Nueva credencial de familiar
                        </h2>
                        <p class="mt-1 truncate text-sm text-slate-600">
                            {{ $familiar['name'] ?: 'Nombre no disponible' }}
                            <span class="mx-1 text-slate-400">·</span>
                            Folio {{ $familiar['file_number'] ?: 'no disponible' }}
                        </p>
                    </div>
                    <button type="button" wire:click="close" aria-label="Cerrar nueva credencial"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18" />
                        </svg>
                    </button>
                </header>

                <div class="min-h-0 flex-1 space-y-5 overflow-y-auto p-4 sm:p-6">
                    @if ($saveError)
                        <p class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
                            role="alert">
                            {{ $saveError }}
                        </p>
                    @endif

                    @if ($eligibilityIssues)
                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900"
                            role="alert">
                            <p class="font-semibold">No se puede generar la credencial:</p>
                            <ul class="mt-2 list-inside list-disc">
                                @foreach ($eligibilityIssues as $issue)
                                    <li>{{ $issue }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
                            role="alert">
                            <ul class="list-inside list-disc space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form wire:submit="createCredential" class="space-y-4">
                        <div>
                            <label for="beneficiary-credential-issued-date"
                                class="mb-1 block text-sm font-medium text-slate-700">
                                Fecha de emisión
                            </label>
                            <input id="beneficiary-credential-issued-date" type="date" value="{{ $issuedDate }}" disabled
                                class="w-full rounded-lg border border-[#D9CBC5] bg-slate-100 px-3 py-2.5 text-sm text-slate-600">
                            <p class="mt-1 text-xs text-slate-500">
                                Se establecerá automáticamente al generar la credencial.
                            </p>
                        </div>

                        <div>
                            <label for="beneficiary-credential-expires-at"
                                class="mb-1 block text-sm font-medium text-slate-700">
                                Fecha de vigencia <span class="text-red-600">*</span>
                            </label>
                            <input id="beneficiary-credential-expires-at" type="date" wire:model="expiresAt" required
                                @disabled($eligibilityIssues)
                                class="w-full rounded-lg border border-[#D9CBC5] px-3 py-2.5 text-sm focus:border-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20 disabled:cursor-not-allowed disabled:bg-slate-100">
                            @error('expiresAt')
                                <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                            @enderror
                        </div>

                        <footer class="flex flex-col-reverse justify-end gap-2 border-t border-[#E7DFD9] pt-4 sm:flex-row">
                            <button type="button" wire:click="close"
                                class="rounded-lg border border-[#E7DFD9] bg-white px-5 py-2.5 text-center text-sm font-medium text-[#651F34] transition hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2">
                                Cancelar
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="createCredential"
                                @disabled($eligibilityIssues || blank($expiresAt))
                                class="rounded-lg bg-[#651F34] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
                                <span wire:loading.remove wire:target="createCredential">Generar credencial</span>
                                <span wire:loading wire:target="createCredential">Generando...</span>
                            </button>
                        </footer>
                    </form>
                </div>
            </section>
        </div>
    @endif
</div>

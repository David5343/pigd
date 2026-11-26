<div>
    @if ($isOpen && $expediente)
        <div wire:click.self="close" wire:keydown.escape.window="handleEscape"
            role="dialog" aria-modal="true" aria-labelledby="beneficiary-credentials-title"
            class="fixed inset-0 z-[90] overflow-y-auto bg-black/60 p-3 sm:p-6">
            <section
                class="relative mx-auto my-2 flex max-h-[calc(100vh-1.5rem)] w-full max-w-5xl flex-col overflow-hidden rounded-2xl border border-[#E7DFD9] bg-white shadow-2xl sm:my-6 sm:max-h-[calc(100vh-3rem)]">
                <header class="flex shrink-0 items-center justify-between gap-4 border-b border-[#E7DFD9] bg-[#F7F3EC] px-4 py-4 sm:px-6">
                    <div class="min-w-0">
                        <h2 id="beneficiary-credentials-title" class="text-lg font-semibold text-[#651F34]">
                            Historial de credenciales del familiar
                        </h2>
                        <p class="mt-1 truncate text-sm text-slate-600">
                            {{ $expediente['nombreFamiliar'] ?: 'Familiar' }}
                            <span class="mx-1 text-slate-400">·</span>
                            Folio {{ $expediente['folioAfiliacion'] ?: 'no disponible' }}
                            <span class="mx-1 text-slate-400">·</span>
                            {{ count($expediente['credenciales']) }} registros
                        </p>
                    </div>
                    <button type="button" wire:click="close" aria-label="Cerrar historial de credenciales"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18" />
                        </svg>
                    </button>
                </header>

                <div class="min-h-0 flex-1 overflow-y-auto p-4 sm:p-6">
                    @if ($successMessage)
                        <p class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"
                            role="status">
                            {{ $successMessage }}
                        </p>
                    @endif

                    @if ($canCreateCredential)
                        <div class="mb-4 flex justify-end">
                            <button type="button" wire:click="openCreateCredential"
                                class="inline-flex items-center gap-2 rounded-lg border border-[#E7DFD9] bg-white px-4 py-2.5 text-xs font-medium uppercase text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" />
                                </svg>
                                Nueva credencial
                            </button>
                        </div>
                    @endif

                    @if (!empty($expediente['credenciales']))
                        <div class="overflow-x-auto rounded-lg border border-[#E7DFD9]">
                            <table class="min-w-full divide-y divide-[#E7DFD9] text-left text-sm">
                                <thead class="bg-[#F7F3EC] text-xs uppercase tracking-wide text-gray-600">
                                    <tr>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Número de credencial</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Fecha de emisión</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Vigente hasta</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Tipo de vigencia</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#E7DFD9]">
                                    @foreach ($expediente['credenciales'] as $credencial)
                                        @php
                                            $claseEstatus = match (strtoupper($credencial['estatus'] ?? '')) {
                                                'VIGENTE' => 'bg-green-100 text-green-800',
                                                'VENCIDA' => 'bg-gray-100 text-gray-700',
                                                default => 'bg-yellow-100 text-yellow-800',
                                            };
                                        @endphp
                                        <tr wire:key="beneficiary-credential-{{ $credencial['numero'] }}"
                                            class="hover:bg-slate-50">
                                            <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">
                                                {{ $credencial['numero'] }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                                {{ $credencial['emitida'] ?: 'No disponible' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                                {{ $credencial['vigente_hasta'] ?: 'No disponible' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                                {{ $credencial['tipo_vigencia'] ?: 'No especificado' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $claseEstatus }}">
                                                    {{ $credencial['estatus'] ?: 'Sin estatus' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="rounded-lg bg-[#F7F3EC] px-4 py-8 text-center text-sm text-slate-600">
                            Este familiar no tiene credenciales registradas.
                        </p>
                    @endif
                </div>
            </section>
        </div>
    @endif

    <livewire:socioeconomic-benefits.beneficiary-credential-create-form />
</div>

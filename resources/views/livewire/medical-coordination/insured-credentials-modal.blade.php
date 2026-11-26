<div>
    @if ($isOpen && $expediente)
        <div wire:click.self="close" wire:keydown.escape.window="handleEscape"
            role="dialog" aria-modal="true" aria-labelledby="insured-credentials-modal-title"
            class="fixed inset-0 z-[90] overflow-y-auto bg-black/60 p-3 sm:p-6">
            <section
                class="relative mx-auto my-2 flex max-h-[calc(100vh-1.5rem)] w-full max-w-6xl flex-col overflow-hidden rounded-2xl border border-[#E7DFD9] bg-white shadow-2xl sm:my-6 sm:max-h-[calc(100vh-3rem)]">
                <div class="flex shrink-0 items-center justify-between gap-4 border-b border-[#E7DFD9] bg-[#F7F3EC] px-4 py-4 sm:px-6">
                    <div class="min-w-0">
                        <h2 id="insured-credentials-modal-title" class="text-lg font-semibold text-[#651F34]">
                            Historial de credenciales
                        </h2>
                        <p class="mt-1 truncate text-sm text-slate-600">
                            {{ $expediente['nombreTitular'] ?: 'Titular' }}
                            <span class="mx-1 text-slate-400">·</span>
                            Folio {{ $expediente['folioAfiliacion'] ?: 'no disponible' }}
                            <span class="mx-1 text-slate-400">·</span>
                            {{ count($expediente['credenciales']) }} registros
                        </p>
                    </div>
                    <button type="button" wire:click="close" aria-label="Cerrar historial de credenciales"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#075e56]">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 0 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>
                </div>

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
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 5v14m-7-7h14" />
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
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Estatus de credencial</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center font-semibold">PDF</th>
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
                                        <tr class="hover:bg-slate-50">
                                            <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">{{ $credencial['numero'] }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $credencial['emitida'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $credencial['vigente_hasta'] ?: 'No disponible' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $credencial['tipo_vigencia'] }}</td>
                                            <td class="whitespace-nowrap px-4 py-3">
                                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $claseEstatus }}">
                                                    {{ $credencial['estatus'] ?: 'Sin estatus' }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                                <a href="{{ route('socioeconomic_benefits.insured-credential-pdf', [$expediente['id'], $credencial['numero']]) }}"
                                                    target="_blank" rel="noopener"
                                                    title="Ver o imprimir credencial"
                                                    aria-label="Ver o imprimir la credencial {{ $credencial['numero'] }}"
                                                    class="inline-flex items-center justify-center rounded-lg border border-[#E7DFD9] bg-white p-2 text-[#651F34] shadow-sm transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.75 8.25V3.75h10.5v4.5m-10.5 9H5.25A2.25 2.25 0 0 1 3 15v-4.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 10.5V15a2.25 2.25 0 0 1-2.25 2.25h-1.5m-10.5 0v4.5h10.5v-4.5m-10.5 0h10.5m-10.5-6h.008v.008H8.25v-.008Z" />
                                                    </svg>
                                                    <span class="sr-only">Ver PDF</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="rounded-lg bg-[#F7F3EC] px-4 py-8 text-center text-sm text-slate-600">
                            Este titular no tiene credenciales registradas.
                        </p>
                    @endif
                </div>
            </section>
        </div>
    @endif

    <livewire:socioeconomic-benefits.insured-credential-create-form />
</div>

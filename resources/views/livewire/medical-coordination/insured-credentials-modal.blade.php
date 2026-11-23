<div>
    @if ($isOpen && $expediente)
        <div wire:click.self="close" wire:keydown.escape.window="close"
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
                    @if (!empty($expediente['credenciales']))
                        <div class="overflow-x-auto rounded-lg border border-[#E7DFD9]">
                            <table class="min-w-full divide-y divide-[#E7DFD9] text-left text-sm">
                                <thead class="bg-[#F7F3EC] text-xs uppercase tracking-wide text-gray-600">
                                    <tr>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Número de credencial</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Fecha de emisión</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Vigente hasta</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Motivo de emisión</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 font-semibold">Estatus de credencial</th>
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
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">{{ $credencial['motivo'] }}</td>
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
                            Este titular no tiene credenciales registradas.
                        </p>
                    @endif
                </div>
            </section>
        </div>
    @endif
</div>

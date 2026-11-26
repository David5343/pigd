<div>
    @if ($isOpen && $pensionerData)
        <div wire:click.self="close" wire:keydown.escape.window="close"
            role="dialog" aria-modal="true" aria-labelledby="pensioner-families-modal-title"
            class="fixed inset-0 z-[90] overflow-y-auto bg-black/60 p-3 sm:p-6">
            <section
                class="relative mx-auto my-2 flex max-h-[calc(100vh-1.5rem)] w-full max-w-5xl flex-col overflow-hidden rounded-2xl border border-[#E7DFD9] bg-white shadow-2xl sm:my-6 sm:max-h-[calc(100vh-3rem)]">
                <header
                    class="flex shrink-0 items-center justify-between gap-4 border-b border-[#E7DFD9] bg-[#F7F3EC] px-4 py-4 sm:px-6">
                    <div class="min-w-0">
                        <h2 id="pensioner-families-modal-title" class="text-lg font-semibold text-[#651F34]">
                            Familiares del pensionado
                        </h2>
                        <p class="mt-1 truncate text-sm text-slate-600">
                            {{ $pensionerData['nombre'] ?: 'Pensionado' }}
                            <span class="mx-1 text-slate-400">·</span>
                            NOI {{ $pensionerData['noi_number'] ?: 'no disponible' }}
                            <span class="mx-1 text-slate-400">·</span>
                            {{ count($pensionerData['familiares']) }} registrados
                        </p>
                    </div>
                    <button type="button" wire:click="close" aria-label="Cerrar familiares del pensionado"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>
                </header>

                <div class="min-h-0 flex-1 overflow-y-auto p-4 sm:p-6">
                    @if (!empty($pensionerData['familiares']))
                        <div class="overflow-x-auto rounded-lg border border-[#E7DFD9]">
                            <table class="min-w-full divide-y divide-[#E7DFD9] text-left text-sm">
                                <thead class="bg-[#F7F3EC] text-xs uppercase tracking-wide text-gray-600">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 font-semibold">Nombre completo</th>
                                        <th scope="col" class="px-4 py-3 font-semibold">Parentesco</th>
                                        <th scope="col" class="px-4 py-3 font-semibold">Folio</th>
                                        <th scope="col" class="px-4 py-3 font-semibold">CURP</th>
                                        <th scope="col" class="px-4 py-3 text-center font-semibold">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#E7DFD9]">
                                    @foreach ($pensionerData['familiares'] as $familiar)
                                        @php
                                            $estatusFamiliar = trim($familiar['estatus'] ?? '');
                                            $clases = match (mb_strtolower($estatusFamiliar)) {
                                                'activo' => [
                                                    'badge' => 'border-green-200 bg-green-50 text-green-800',
                                                    'dot' => 'bg-green-500',
                                                ],
                                                'baja' => [
                                                    'badge' => 'border-red-200 bg-red-50 text-red-800',
                                                    'dot' => 'bg-red-500',
                                                ],
                                                default => [
                                                    'badge' => 'border-slate-200 bg-slate-50 text-slate-700',
                                                    'dot' => 'bg-slate-400',
                                                ],
                                            };
                                        @endphp
                                        <tr wire:key="pensioner-family-{{ $familiar['id'] }}"
                                            class="hover:bg-slate-50">
                                            <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900">
                                                {{ $familiar['nombre'] ?: 'Nombre no disponible' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                                {{ $familiar['parentesco'] ?: 'No disponible' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                                {{ $familiar['folio'] ?: 'No disponible' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                                {{ $familiar['curp'] ?: 'No disponible' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                                <span
                                                    class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold {{ $clases['badge'] }}">
                                                    <span
                                                        class="h-2 w-2 rounded-full ring-2 ring-white {{ $clases['dot'] }}"
                                                        aria-hidden="true"></span>
                                                    {{ $estatusFamiliar ?: 'Sin estatus de afiliación' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="rounded-lg bg-[#F7F3EC] px-4 py-8 text-center text-sm text-slate-600">
                            Este pensionado no tiene familiares registrados.
                        </p>
                    @endif
                </div>
            </section>
        </div>
    @endif
</div>

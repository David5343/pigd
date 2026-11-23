<div>
    @if ($isOpen && $expediente)
        <div wire:click.self="close" wire:keydown.escape.window="close"
            role="dialog" aria-modal="true" aria-labelledby="insured-expedient-modal-title"
            class="fixed inset-0 z-[90] overflow-y-auto bg-black/60 p-3 sm:p-6">
            <section
                class="relative mx-auto my-2 flex max-h-[calc(100vh-1.5rem)] w-full max-w-7xl flex-col overflow-hidden rounded-2xl border border-[#E7DFD9] bg-[#F7F3EC] shadow-2xl sm:my-6 sm:max-h-[calc(100vh-3rem)]">
                <div class="flex shrink-0 items-center justify-between gap-4 border-b border-[#E7DFD9] bg-white px-4 py-3 sm:px-6">
                    <div>
                        <h2 id="insured-expedient-modal-title" class="font-semibold text-[#651F34]">
                            Expediente electrónico
                        </h2>
                    </div>
                    <button type="button" wire:click="close" aria-label="Cerrar expediente"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#075e56]">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path
                                d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 0 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>
                </div>

                <div class="min-h-0 flex-1 overflow-y-auto p-4 sm:p-6">
                    @include('medical_coordination.membership.partials.expedient-content', $expediente)
                </div>
            </section>
        </div>
    @endif
</div>

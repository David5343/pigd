<div>
    @if ($isOpen && $expediente)
        <div x-data="{
                dragging: false,
                offsetX: 0,
                offsetY: 0,
                pointerStartX: 0,
                pointerStartY: 0,
                initialOffsetX: 0,
                initialOffsetY: 0,
                baseLeft: 0,
                baseTop: 0,
                panelWidth: 0,
                panelHeight: 0,
                startDrag(event) {
                    if (event.button !== 0) return;
                    const rect = this.$refs.panel.getBoundingClientRect();
                    this.dragging = true;
                    this.pointerStartX = event.clientX;
                    this.pointerStartY = event.clientY;
                    this.initialOffsetX = this.offsetX;
                    this.initialOffsetY = this.offsetY;
                    this.baseLeft = rect.left - this.offsetX;
                    this.baseTop = rect.top - this.offsetY;
                    this.panelWidth = rect.width;
                    this.panelHeight = rect.height;
                    event.currentTarget.setPointerCapture(event.pointerId);
                },
                moveDrag(event) {
                    if (!this.dragging) return;
                    const minX = 12 - this.baseLeft;
                    const maxX = window.innerWidth - this.panelWidth - 12 - this.baseLeft;
                    const minY = 12 - this.baseTop;
                    const maxY = window.innerHeight - this.panelHeight - 12 - this.baseTop;
                    this.offsetX = Math.min(maxX, Math.max(minX, this.initialOffsetX + event.clientX - this.pointerStartX));
                    this.offsetY = Math.min(maxY, Math.max(minY, this.initialOffsetY + event.clientY - this.pointerStartY));
                },
                stopDrag() {
                    this.dragging = false;
                }
            }"
            @pointermove.window="moveDrag($event)"
            @pointerup.window="stopDrag()"
            @pointercancel.window="stopDrag()"
            wire:click.self="close" wire:keydown.escape.window="close"
            role="dialog" aria-modal="true" aria-labelledby="insured-expedient-modal-title"
            class="fixed inset-0 z-[90] flex items-start justify-center overflow-y-auto bg-black/60 p-3 sm:items-center sm:p-6">
            <section
                x-ref="panel"
                x-bind:style="'transform: translate(' + offsetX + 'px, ' + offsetY + 'px)'"
                class="relative my-2 flex max-h-[85vh] w-full max-w-7xl flex-col overflow-hidden rounded-2xl border border-[#E7DFD9] bg-[#F7F3EC] shadow-2xl sm:my-6">
                <div class="flex shrink-0 items-center justify-between gap-4 border-b border-[#E7DFD9] bg-white px-4 py-3 sm:px-6">
                    <div @pointerdown.prevent="startDrag($event)"
                        class="flex min-w-0 flex-1 cursor-grab touch-none select-none items-center gap-3"
                        :class="dragging ? 'cursor-grabbing' : ''">
                        <svg class="h-5 w-5 shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path
                                d="M7 3a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM7 10a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM5.5 18.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM16 3a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM14.5 11.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM16 17a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                        <div class="min-w-0">
                            <h2 id="insured-expedient-modal-title" class="font-semibold text-[#651F34]">
                                Expediente electrónico
                            </h2>
                            <p class="text-xs text-slate-500">Arrastra aquí para mover la ventana</p>
                        </div>
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

<div>
    @if ($isOpen && $titular)
        <div wire:click.self="close" wire:keydown.escape.window="close"
            role="dialog" aria-modal="true" aria-labelledby="insured-signature-modal-title"
            class="fixed inset-0 z-[110] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
            <section class="w-full max-w-2xl overflow-hidden rounded-2xl border border-[#E7DFD9] bg-white shadow-2xl">
                <header class="flex items-start justify-between gap-4 border-b border-[#E7DFD9] bg-[#F7F3EC] px-5 py-4 sm:px-6">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8A6670]">
                            Prestaciones Socioeconómicas
                        </p>
                        <h2 id="insured-signature-modal-title" class="mt-1 text-lg font-semibold text-[#651F34]">
                            Captura de firma
                        </h2>
                        <p class="mt-1 truncate text-sm text-slate-600">
                            {{ $titular['name'] ?: 'Nombre no disponible' }}
                            <span class="mx-1 text-slate-400">·</span>
                            Folio {{ $titular['file_number'] ?: 'no disponible' }}
                        </p>
                    </div>
                    <button type="button" wire:click="close"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#651F34]"
                        aria-label="Cerrar captura de firma">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18" />
                        </svg>
                    </button>
                </header>

                <div x-data="{
                        captureMode: 'tablet',
                        tabletTimer: null,
                        captureError: '',
                        uploadError: '',
                        uploadProgress: null,
                        capturing: false,
                        drawing: false,
                        hasTouchSignature: false,
                        uploadedFilename: null,
                        removingUpload: false,
                        tabletReady() {
                            return typeof IsSigWebInstalled === 'function'
                                && typeof TabletConnectQuery === 'function'
                                && typeof SetTabletComTest === 'function'
                                && typeof SetTabletState === 'function'
                                && typeof GetTabletState === 'function'
                                && typeof NumberOfTabletPoints === 'function'
                                && typeof GetSigImageB64 === 'function'
                                && typeof ClearTablet === 'function'
                                && typeof SetImageXSize === 'function'
                                && typeof SetImageYSize === 'function';
                        },
                        clearCanvas() {
                            const canvas = this.$refs.signatureCanvas;
                            if (canvas) {
                                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                            }
                        },
                        selectMode(mode) {
                            if (this.captureMode === mode || this.uploadedFilename || this.removingUpload
                                || (this.uploadProgress !== null && this.uploadProgress < 100)) {
                                return;
                            }

                            this.stopCapture();
                            if (this.captureMode === 'tablet' && typeof ClearTablet === 'function') {
                                try {
                                    ClearTablet();
                                } catch (error) {
                                    // SigWeb may be unavailable when switching to touch capture.
                                }
                            }
                            this.clearCanvas();
                            this.captureMode = mode;
                            this.hasTouchSignature = false;
                            this.captureError = '';
                            this.uploadError = '';
                            this.uploadProgress = null;
                        },
                        pointerPosition(event) {
                            const canvas = this.$refs.signatureCanvas;
                            const bounds = canvas.getBoundingClientRect();

                            return {
                                x: (event.clientX - bounds.left) * (canvas.width / bounds.width),
                                y: (event.clientY - bounds.top) * (canvas.height / bounds.height),
                            };
                        },
                        startTouchDrawing(event) {
                            if (this.captureMode !== 'touch' || this.uploadedFilename || this.removingUpload) return;

                            const canvas = this.$refs.signatureCanvas;
                            const context = canvas.getContext('2d');
                            const point = this.pointerPosition(event);

                            this.captureError = '';
                            this.drawing = true;
                            this.hasTouchSignature = true;
                            context.lineWidth = 4;
                            context.lineCap = 'round';
                            context.lineJoin = 'round';
                            context.strokeStyle = '#111827';
                            context.fillStyle = '#111827';
                            context.beginPath();
                            context.arc(point.x, point.y, context.lineWidth / 2, 0, Math.PI * 2);
                            context.fill();
                            context.beginPath();
                            context.moveTo(point.x, point.y);
                            canvas.setPointerCapture(event.pointerId);
                        },
                        drawTouch(event) {
                            if (this.captureMode !== 'touch' || !this.drawing) return;

                            const context = this.$refs.signatureCanvas.getContext('2d');
                            const point = this.pointerPosition(event);

                            context.lineTo(point.x, point.y);
                            context.stroke();
                        },
                        endTouchDrawing(event) {
                            if (!this.drawing) return;

                            this.drawing = false;
                            const canvas = this.$refs.signatureCanvas;
                            if (canvas.hasPointerCapture(event.pointerId)) {
                                canvas.releasePointerCapture(event.pointerId);
                            }
                        },
                        uploadSignature(wire, image) {
                            this.uploadProgress = 0;
                            this.uploadError = '';
                            wire.upload('signatureImage', image,
                                (uploadedFilename) => {
                                    this.uploadedFilename = uploadedFilename;
                                    this.uploadProgress = 100;
                                },
                                () => {
                                    this.uploadError = 'No se pudo cargar la firma. Intenta nuevamente.';
                                    this.uploadProgress = null;
                                },
                                (event) => { this.uploadProgress = event.detail.progress; },
                                () => { this.uploadProgress = null; }
                            );
                        },
                        startCapture() {
                            if (this.captureMode !== 'tablet' || this.uploadedFilename || this.removingUpload) return;
                            this.captureError = '';

                            if (!this.tabletReady()) {
                                this.captureError = 'No se detectó SigWeb. Verifica que esté instalado y ejecutándose en este equipo.';
                                return;
                            }

                            try {
                                SetTabletComTest(true);
                                const connection = String(TabletConnectQuery()).trim().toLowerCase();
                                SetTabletComTest(false);

                                if (!['1', 'true'].includes(connection)) {
                                    this.captureError = 'No se detectó el digitalizador Topaz. Conéctalo y vuelve a intentar.';
                                    return;
                                }

                                ClearTablet();
                                const canvas = this.$refs.signatureCanvas;
                                const context = canvas.getContext('2d');
                                context.clearRect(0, 0, canvas.width, canvas.height);
                                SetImageXSize(canvas.width);
                                SetImageYSize(canvas.height);
                                this.tabletTimer = SetTabletState(1, context, 50);

                                if (Number(GetTabletState()) !== 1) {
                                    this.stopCapture();
                                    this.captureError = 'SigWeb no pudo activar el digitalizador. Revisa su conexión y el permiso de red local del navegador.';
                                    return;
                                }

                                this.capturing = true;
                            } catch (error) {
                                try {
                                    SetTabletComTest(false);
                                } catch (cleanupError) {
                                    // SigWeb may be unavailable; still show the capture error.
                                }
                                this.stopCapture();
                                this.captureError = 'No se pudo comunicar con SigWeb. Revisa HTTPS, el permiso de red local y que el servicio esté activo.';
                            }
                        },
                        stopCapture() {
                            if (this.tabletTimer !== null && typeof SetTabletState === 'function') {
                                try {
                                    SetTabletState(0, this.tabletTimer);
                                } catch (error) {
                                    // The tablet can disconnect while the modal is open.
                                }
                            }
                            this.tabletTimer = null;
                            this.capturing = false;
                        },
                        clearSignature(wire) {
                            this.stopCapture();
                            if (this.captureMode === 'tablet' && typeof ClearTablet === 'function') {
                                try {
                                    ClearTablet();
                                } catch (error) {
                                    // SigWeb may be unavailable; the local canvas can still be cleared.
                                }
                            }
                            this.clearCanvas();
                            this.hasTouchSignature = false;
                            this.captureError = '';
                            this.uploadError = '';

                            if (this.uploadedFilename) {
                                this.removingUpload = true;
                                wire.removeUpload('signatureImage', this.uploadedFilename, () => {
                                    this.uploadedFilename = null;
                                    this.uploadProgress = null;
                                    this.removingUpload = false;
                                });
                            } else if (this.uploadProgress !== null && this.uploadProgress < 100) {
                                wire.cancelUpload('signatureImage');
                                this.uploadProgress = null;
                            }
                        },
                        captureTabletSignature(wire) {
                            if (this.captureMode !== 'tablet' || !this.capturing || this.uploadedFilename) return;
                            this.captureError = '';
                            this.uploadError = '';
                            this.uploadProgress = null;
                            this.stopCapture();

                            if (Number(NumberOfTabletPoints()) <= 0) {
                                this.captureError = 'La tableta no registró trazos. Firma en el digitalizador e intenta de nuevo.';
                                return;
                            }

                            GetSigImageB64((base64Image) => {
                                if (!base64Image) {
                                    this.captureError = 'SigWeb no devolvió la imagen de la firma.';
                                    return;
                                }

                                const base64 = base64Image.replace(/^data:image\/png;base64,/, '');
                                const binary = atob(base64);
                                const bytes = new Uint8Array(binary.length);
                                for (let index = 0; index < binary.length; index++) {
                                    bytes[index] = binary.charCodeAt(index);
                                }

                                const image = new File([bytes], 'firma.png', { type: 'image/png' });
                                this.uploadSignature(wire, image);
                            });
                        },
                        captureTouchSignature(wire) {
                            if (this.captureMode !== 'touch' || !this.hasTouchSignature
                                || this.uploadedFilename || this.removingUpload) {
                                return;
                            }

                            this.captureError = '';
                            this.uploadError = '';
                            this.$refs.signatureCanvas.toBlob((blob) => {
                                if (!blob) {
                                    this.captureError = 'No se pudo preparar la imagen de la firma táctil.';
                                    return;
                                }

                                this.uploadSignature(wire, new File([blob], 'firma.png', { type: 'image/png' }));
                            }, 'image/png');
                        },
                        destroy() {
                            this.stopCapture();
                            if (typeof Reset === 'function') Reset();
                        }
                    }"
                    class="space-y-4 p-5 sm:p-6">
                    @if ($currentSignatureUrl)
                        <div class="rounded-lg border border-[#E7DFD9] bg-[#F7F3EC] p-3">
                            <p class="mb-2 text-sm font-medium text-[#651F34]">Firma actual</p>
                            <img src="{{ $currentSignatureUrl }}" alt="Firma actual del titular"
                                class="mx-auto max-h-24 max-w-full object-contain">
                        </div>
                    @endif
                    @if ($hasLegacySignature)
                        <p class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs leading-5 text-amber-900">
                            Existe una firma anterior en formato heredado. Al guardar una nueva firma se reemplazará la referencia actual.
                        </p>
                    @endif

                    <div class="flex rounded-lg border border-[#E7DFD9] bg-[#F7F3EC] p-1" role="tablist"
                        aria-label="Método de captura de firma">
                        <button type="button" role="tab" aria-controls="signature-tablet-panel"
                            x-bind:aria-selected="(captureMode === 'tablet').toString()"
                            x-bind:disabled="!!uploadedFilename || removingUpload || (uploadProgress !== null && uploadProgress < 100)"
                            x-on:click="selectMode('tablet')"
                            x-bind:class="captureMode === 'tablet' ? 'bg-white text-[#651F34] shadow-sm' : 'text-slate-600 hover:text-[#651F34]'"
                            class="flex-1 rounded-md px-3 py-2 text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-[#651F34] disabled:cursor-not-allowed disabled:opacity-50">
                            Pad Topaz
                        </button>
                        <button type="button" role="tab" aria-controls="signature-touch-panel"
                            x-bind:aria-selected="(captureMode === 'touch').toString()"
                            x-bind:disabled="!!uploadedFilename || removingUpload || (uploadProgress !== null && uploadProgress < 100)"
                            x-on:click="selectMode('touch')"
                            x-bind:class="captureMode === 'touch' ? 'bg-white text-[#651F34] shadow-sm' : 'text-slate-600 hover:text-[#651F34]'"
                            class="flex-1 rounded-md px-3 py-2 text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-[#651F34] disabled:cursor-not-allowed disabled:opacity-50">
                            Pantalla táctil
                        </button>
                    </div>

                    <div class="overflow-hidden rounded-xl border border-[#D9CBC5] bg-white">
                        <canvas x-ref="signatureCanvas" width="640" height="220"
                            x-on:pointerdown.prevent="startTouchDrawing($event)"
                            x-on:pointermove.prevent="drawTouch($event)"
                            x-on:pointerup.prevent="endTouchDrawing($event)"
                            x-on:pointercancel="endTouchDrawing($event)"
                            aria-label="Vista previa de la firma capturada"
                            class="block h-auto max-h-56 w-full touch-none"></canvas>
                    </div>

                    <p x-show="captureMode === 'tablet'" id="signature-tablet-panel"
                        class="text-xs leading-5 text-slate-500" role="tabpanel">
                        Firma en el digitalizador Topaz conectado a este equipo. SigWeb debe estar instalado y el navegador debe permitir la comunicación local.
                    </p>
                    <p x-cloak x-show="captureMode === 'touch'" id="signature-touch-panel"
                        class="text-xs leading-5 text-slate-500" role="tabpanel">
                        Firma dentro del recuadro con el dedo o un lápiz táctil. Puedes borrar y repetir antes de guardar.
                    </p>

                    <div x-show="captureError" x-cloak x-text="captureError"
                        class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-900"
                        role="alert"></div>
                    <div x-show="uploadError" x-cloak x-text="uploadError"
                        class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-800"
                        role="alert"></div>
                    @error('signatureImage')
                        <p class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-800" role="alert">
                            {{ $message }}
                        </p>
                    @enderror
                    @if ($uploadError)
                        <p class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-800" role="alert">
                            {{ $uploadError }}
                        </p>
                    @endif
                    @if ($successMessage)
                        <p class="rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-sm text-green-800" role="status">
                            {{ $successMessage }}
                        </p>
                    @endif
                    <div x-show="uploadProgress !== null && uploadProgress < 100" x-cloak
                        class="text-sm text-slate-600" role="status">
                        Cargando firma: <span x-text="uploadProgress"></span>%
                    </div>

                    <div class="flex flex-col-reverse justify-end gap-2 sm:flex-row">
                        <button type="button" wire:click="close" x-on:click="stopCapture()"
                            class="rounded-lg border border-[#E7DFD9] bg-white px-4 py-2 text-sm font-medium text-[#651F34] transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                            Cerrar
                        </button>
                        <button type="button" x-on:click="clearSignature($wire)" x-bind:disabled="capturing || removingUpload"
                            class="rounded-lg border border-[#E7DFD9] bg-white px-4 py-2 text-sm font-medium text-[#651F34] transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] disabled:cursor-not-allowed disabled:opacity-50">
                            Limpiar
                        </button>
                        <button type="button" x-show="captureMode === 'tablet'" x-on:click="startCapture()"
                            x-bind:disabled="capturing || !!uploadedFilename || removingUpload"
                            class="rounded-lg border border-[#E7DFD9] bg-white px-4 py-2 text-sm font-medium text-[#651F34] transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] disabled:cursor-not-allowed disabled:opacity-50">
                            Iniciar firma
                        </button>
                        <button type="button" x-show="captureMode === 'tablet'"
                            x-on:click="captureTabletSignature($wire)"
                            x-bind:disabled="!capturing || !!uploadedFilename || removingUpload"
                            class="rounded-lg bg-[#651F34] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] disabled:cursor-not-allowed disabled:bg-slate-300">
                            Capturar firma
                        </button>
                        <button type="button" x-cloak x-show="captureMode === 'touch'"
                            x-on:click="captureTouchSignature($wire)"
                            x-bind:disabled="!hasTouchSignature || !!uploadedFilename || removingUpload"
                            class="rounded-lg bg-[#651F34] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] disabled:cursor-not-allowed disabled:bg-slate-300">
                            Usar esta firma
                        </button>
                        <button type="button" wire:click="saveSignature" wire:loading.attr="disabled"
                            wire:target="saveSignature,signatureImage" @disabled(! $signatureImage)
                            class="rounded-lg bg-[#651F34] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2 disabled:cursor-not-allowed disabled:bg-slate-300">
                            Guardar firma
                        </button>
                    </div>
                </div>
            </section>
        </div>
    @endif
</div>

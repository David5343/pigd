<div>
    @if ($isOpen && $titular)
        <div x-data="{
                source: 'webcam',
                stream: null,
                cameraError: '',
                uploadProgress: null,
                secureContext: window.isSecureContext && !!navigator.mediaDevices?.getUserMedia,
                async startCamera() {
                    this.cameraError = '';
                    if (!this.secureContext) {
                        this.cameraError = 'La webcam en vivo requiere HTTPS. Puedes usar el modo Cámara del móvil mientras tanto.';
                        return;
                    }

                    try {
                        this.stream = await navigator.mediaDevices.getUserMedia({
                            audio: false,
                            video: { facingMode: 'user' },
                        });
                        this.$refs.cameraVideo.srcObject = this.stream;
                        await this.$refs.cameraVideo.play();
                    } catch (error) {
                        this.cameraError = error.name === 'NotAllowedError'
                            ? 'No se concedió permiso para usar la cámara.'
                            : error.name === 'NotFoundError'
                                ? 'No se encontró una cámara conectada.'
                                : 'No se pudo iniciar la cámara. Verifica que no esté siendo usada por otra aplicación.';
                    }
                },
                stopCamera() {
                    if (this.stream) {
                        this.stream.getTracks().forEach((track) => track.stop());
                        this.stream = null;
                    }
                    if (this.$refs.cameraVideo) this.$refs.cameraVideo.srcObject = null;
                },
                selectSource(source) {
                    this.stopCamera();
                    this.cameraError = '';
                    this.uploadProgress = null;
                    this.source = source;
                },
                captureFrame(wire) {
                    const video = this.$refs.cameraVideo;
                    if (!this.stream || !video.videoWidth || !video.videoHeight) {
                        this.cameraError = 'Inicia la webcam y espera a que aparezca la imagen.';
                        return;
                    }

                    const canvas = document.createElement('canvas');
                    const scale = Math.min(1, 1600 / Math.max(video.videoWidth, video.videoHeight));
                    canvas.width = Math.round(video.videoWidth * scale);
                    canvas.height = Math.round(video.videoHeight * scale);
                    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

                    canvas.toBlob((blob) => {
                        if (!blob) {
                            this.cameraError = 'No se pudo preparar la fotografía.';
                            return;
                        }

                        this.stopCamera();
                        const image = new File([blob], 'titular.jpg', { type: 'image/jpeg' });
                        this.uploadProgress = 0;

                        wire.upload('photo', image,
                            () => { this.uploadProgress = 100; },
                            () => {
                                this.cameraError = 'No se pudo cargar la fotografía. Intenta nuevamente.';
                                this.uploadProgress = null;
                            },
                            (event) => { this.uploadProgress = event.detail.progress; }
                        );
                    }, 'image/jpeg', 0.88);
                },
                destroy() {
                    this.stopCamera();
                }
            }"
            wire:click.self="close" wire:keydown.escape.window="close"
            role="dialog" aria-modal="true" aria-labelledby="insured-photo-modal-title"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
            <section class="w-full max-w-lg overflow-hidden rounded-2xl border border-[#E7DFD9] bg-white shadow-2xl">
                <header class="flex items-start justify-between gap-4 border-b border-[#E7DFD9] bg-[#F7F3EC] px-5 py-4 sm:px-6">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8A6670]">
                            Prestaciones Socioeconómicas
                        </p>
                        <h2 id="insured-photo-modal-title" class="mt-1 text-lg font-semibold text-[#651F34]">
                            Fotografía del titular
                        </h2>
                        <p class="mt-1 truncate text-sm text-slate-600">
                            {{ $titular['name'] ?: 'Nombre no disponible' }}
                            <span class="mx-1 text-slate-400">·</span>
                            Folio {{ $titular['file_number'] ?: 'no disponible' }}
                        </p>
                    </div>
                    <button type="button" wire:click="close"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#651F34]"
                        aria-label="Cerrar captura de fotografía">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18" />
                        </svg>
                    </button>
                </header>

                <div class="space-y-5 p-5 sm:p-6">
                    <div class="flex rounded-lg border border-[#E7DFD9] bg-[#F7F3EC] p-1" role="tablist"
                        aria-label="Origen de la fotografía">
                        <button type="button" role="tab" aria-controls="webcam-panel"
                            x-bind:aria-selected="(source === 'webcam').toString()"
                            x-on:click="selectSource('webcam')"
                            x-bind:class="source === 'webcam' ? 'bg-white text-[#651F34] shadow-sm' : 'text-slate-600 hover:text-[#651F34]'"
                            class="flex-1 rounded-md px-3 py-2 text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                            Webcam
                        </button>
                        <button type="button" role="tab" aria-controls="mobile-camera-panel"
                            x-bind:aria-selected="(source === 'mobile').toString()"
                            x-on:click="selectSource('mobile')"
                            x-bind:class="source === 'mobile' ? 'bg-white text-[#651F34] shadow-sm' : 'text-slate-600 hover:text-[#651F34]'"
                            class="flex-1 rounded-md px-3 py-2 text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                            Cámara del móvil
                        </button>
                    </div>

                    <div x-cloak x-show="source === 'webcam'" id="webcam-panel" role="tabpanel">
                        <div class="relative flex aspect-[4/3] items-center justify-center overflow-hidden rounded-xl border border-[#E7DFD9] bg-slate-950">
                            <video x-ref="cameraVideo" x-show="stream" autoplay playsinline
                                class="h-full w-full object-cover"></video>
                            <div x-show="!stream" class="px-6 text-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-white/80"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 7.5 8.1 5.7a1.5 1.5 0 0 1 1.2-.6h5.4a1.5 1.5 0 0 1 1.2.6l1.35 1.8h1.5A2.25 2.25 0 0 1 21 9.75v8.1a2.25 2.25 0 0 1-2.25 2.25h-13.5A2.25 2.25 0 0 1 3 17.85v-8.1A2.25 2.25 0 0 1 5.25 7.5h1.5Z" />
                                    <circle cx="12" cy="13.5" r="3.25" />
                                </svg>
                                <p class="mt-3 text-sm">Activa la webcam para mostrar la vista previa.</p>
                            </div>
                            <div x-cloak x-show="stream"
                                class="pointer-events-none absolute inset-0 z-10 flex items-center justify-center"
                                aria-hidden="true">
                                <div class="h-[82%] w-[58%] rounded-[50%] border-2 border-dashed border-yellow-300"
                                    style="filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.9));"></div>
                            </div>
                        </div>
                        <p class="mt-2 text-center text-xs text-slate-500">
                            Centra el rostro y los hombros dentro del óvalo. La guía no se guarda en la foto.
                        </p>
                        <div class="mt-3 flex flex-wrap justify-center gap-2">
                            <button type="button" x-on:click="startCamera()"
                                x-bind:disabled="!secureContext || !!stream"
                                class="rounded-lg border border-[#E7DFD9] bg-white px-4 py-2 text-sm font-medium text-[#651F34] transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-400">
                                Activar webcam
                            </button>
                            <button type="button" x-on:click="captureFrame($wire)"
                                x-bind:disabled="!stream"
                                class="rounded-lg bg-[#651F34] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] disabled:cursor-not-allowed disabled:bg-slate-300">
                                Capturar foto
                            </button>
                        </div>
                        <p x-show="!secureContext" class="mt-3 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs leading-5 text-amber-900">
                            La webcam en vivo requiere HTTPS o localhost. Esta página está abierta por HTTP.
                        </p>
                    </div>

                    <div x-cloak x-show="source === 'mobile'" id="mobile-camera-panel" role="tabpanel">
                        <label for="mobile-photo" class="mb-2 block text-sm font-medium text-slate-700">
                            Toma una foto con la cámara o selecciona una imagen
                        </label>
                        <input wire:model="photo" type="file" id="mobile-photo" accept="image/*" capture="environment"
                            class="block w-full rounded-lg border border-[#D9CBC5] bg-white text-sm text-slate-700 file:mr-4 file:rounded-l-lg file:border-0 file:bg-[#F7F3EC] file:px-4 file:py-3 file:font-medium file:text-[#651F34] hover:file:bg-[#E7DFD9] focus:outline-none focus:ring-2 focus:ring-[#651F34]/20">
                        <p class="mt-2 text-xs leading-5 text-slate-500">
                            En móviles compatibles se abrirá la cámara trasera. El navegador también puede ofrecer elegir una imagen existente.
                        </p>
                    </div>

                    <div wire:loading wire:target="photo" class="text-sm text-slate-500" role="status">
                        Cargando fotografía…
                    </div>
                    @if ($photo)
                        <div class="rounded-xl border border-[#E7DFD9] bg-[#F7F3EC] p-3">
                            <p class="mb-2 text-sm font-medium text-[#651F34]">Vista previa</p>
                            <div class="relative mx-auto w-fit max-w-full">
                                <img src="{{ $photo->temporaryUrl() }}" alt="Vista previa de la fotografía seleccionada"
                                    class="block max-h-64 max-w-full rounded-lg object-contain shadow-sm">
                                <div class="pointer-events-none absolute inset-0 flex items-center justify-center"
                                    aria-hidden="true">
                                    <div class="h-[78%] w-[58%] rounded-[50%] border-2 border-dashed border-yellow-400"
                                        style="filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.9));"></div>
                                </div>
                            </div>
                            <p class="mt-2 text-center text-xs text-slate-500">
                                Usa el óvalo como guía para centrar el rostro y los hombros.
                            </p>
                        </div>
                    @elseif ($currentPhotoUrl)
                        <div class="rounded-xl border border-[#E7DFD9] bg-[#F7F3EC] p-3">
                            <p class="mb-2 text-sm font-medium text-[#651F34]">Fotografía actual</p>
                            <img src="{{ $currentPhotoUrl }}" alt="Fotografía actual del titular"
                                class="mx-auto max-h-64 rounded-lg object-contain shadow-sm">
                        </div>
                    @endif

                    <p x-cloak x-show="cameraError" x-text="cameraError"
                        class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-900"
                        role="alert"></p>
                    @error('photo')
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

                    <div class="flex flex-col-reverse justify-end gap-2 sm:flex-row">
                        <button type="button" wire:click="close"
                            class="rounded-lg border border-[#E7DFD9] bg-white px-4 py-2 text-sm font-medium text-[#651F34] transition hover:border-[#651F34] hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-1">
                            Cerrar
                        </button>
                        <button type="button" wire:click="savePhoto" wire:loading.attr="disabled"
                            wire:target="savePhoto,photo"
                            @disabled(! $photo)
                            class="rounded-lg bg-[#651F34] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#4F1728] focus:outline-none focus:ring-2 focus:ring-[#651F34] focus:ring-offset-2 disabled:cursor-not-allowed disabled:bg-slate-300">
                            Guardar fotografía
                        </button>
                    </div>
                </div>
            </section>
        </div>
    @endif
</div>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-[#651F34]">
            Prestaciones Socioeconómicas
        </h2>
    </x-slot>

    <div x-data="{
        modalAbierto: false,
        tipoSeleccionado: null,
        nombreTipoSeleccionado: null,
        graficaSeleccionada: null,
        tituloGraficaSeleccionada: null,
        abrirGrafica(tipo, nombre, claveGrafica, titulo) {
            this.tipoSeleccionado = tipo;
            this.nombreTipoSeleccionado = nombre;
            this.graficaSeleccionada = claveGrafica;
            this.tituloGraficaSeleccionada = titulo;
            this.modalAbierto = true;
        },
        cerrarModal() {
            this.modalAbierto = false;
            this.tipoSeleccionado = null;
            this.nombreTipoSeleccionado = null;
            this.graficaSeleccionada = null;
            this.tituloGraficaSeleccionada = null;
        }
    }" @keydown.escape.window="cerrarModal()">
        <section class="space-y-4 py-3" aria-labelledby="estadisticas-prestaciones">
            <div>
                <h3 id="estadisticas-prestaciones" class="text-lg font-semibold text-[#651F34]">
                    Estadísticas generales
                </h3>
                <p class="mt-1 text-sm text-slate-500">
                    Selecciona un tipo de derechohabiente en la leyenda para explorar sus gráficas.
                </p>
            </div>

            @include('socioeconomic_benefits.partials.pie-chart', [
                'grafica' => $graficaGeneral,
                'accionable' => true,
                'graficasPorTipo' => $graficasPorTipo,
            ])
        </section>

        <div x-cloak x-show="modalAbierto" x-transition.opacity @click.self="cerrarModal()"
            role="dialog" aria-modal="true" aria-labelledby="modal-graficas-titulo"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/60 p-3 sm:p-6">
            <div class="mx-auto max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-2xl bg-slate-50 shadow-2xl"
                style="max-width: 42rem;">
                <header class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-slate-200 bg-white px-5 py-4 sm:px-6">
                    <div>
                        <h3 id="modal-graficas-titulo" x-text="tituloGraficaSeleccionada || 'Gráfica seleccionada'"
                            class="text-lg font-semibold text-[#651F34]">
                            Gráfica seleccionada
                        </h3>
                        <p class="mt-1 text-sm text-slate-500" x-text="'Tipo de derechohabiente: ' + nombreTipoSeleccionado">
                        </p>
                    </div>
                    <button type="button" @click="cerrarModal()" aria-label="Cerrar gráficas"
                        class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>
                </header>

                <div class="space-y-4 p-4 sm:p-6">
                    @foreach ($graficasPorTipo as $claveTipo => $grupo)
                        @foreach ($grupo['graficas'] as $claveGrafica => $grafica)
                            <div x-cloak x-show="tipoSeleccionado === '{{ $claveTipo }}' && graficaSeleccionada === '{{ $claveGrafica }}'">
                                @include('socioeconomic_benefits.partials.pie-chart', [
                                    'grafica' => $grafica,
                                    'accionable' => false,
                                ])
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

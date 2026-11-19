@php
    $idGrafica = 'grafica-' . \Illuminate\Support\Str::slug($grafica['titulo']);
@endphp

<article class="rounded-xl border border-[#E7DFD9] bg-white p-4 shadow-sm sm:p-5">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h4 class="font-semibold text-slate-800">{{ $grafica['titulo'] }}</h4>
            <p class="mt-1 text-xs text-slate-500">Distribución por {{ $grafica['criterio'] }}</p>
        </div>
        <p class="shrink-0 text-right text-xs text-slate-500">
            <span class="block text-lg font-bold leading-tight text-[#651F34]">
                {{ number_format($grafica['total']) }}
            </span>
            registros
        </p>
    </div>

    @if ($grafica['nota'])
        <p class="mt-2 text-sm leading-5 text-slate-600">{{ $grafica['nota'] }}</p>
    @endif

    <div class="mt-4 flex flex-col items-center gap-4 sm:flex-row sm:items-center">
        <svg viewBox="0 0 160 160" role="img" aria-labelledby="{{ $idGrafica }}-titulo"
            class="h-20 w-20 shrink-0 drop-shadow-sm">
            <title id="{{ $idGrafica }}-titulo">
                Gráfica de pastel de {{ $grafica['titulo'] }} por {{ $grafica['criterio'] }}
            </title>

            @if ($grafica['total'] === 0)
                <circle cx="80" cy="80" r="70" fill="#e2e8f0" />
            @elseif (count($grafica['segmentos']) === 1)
                <circle cx="80" cy="80" r="70" fill="{{ $grafica['segmentos'][0]['color'] }}"
                    stroke="white" stroke-width="2" />
            @else
                @foreach ($grafica['segmentos'] as $segmento)
                    <path d="{{ $segmento['path'] }}" fill="{{ $segmento['color'] }}"
                        stroke="white" stroke-width="1.5" />
                @endforeach
            @endif
        </svg>

        @if ($grafica['distribucion'])
            <ul class="w-full space-y-2 text-sm">
                @foreach ($grafica['distribucion'] as $segmento)
                    <li x-data="{ listaAbierta: false }" @keydown.escape.stop="listaAbierta = false"
                        class="relative"
                        :style="listaAbierta ? 'z-index: 10000' : 'z-index: auto'">
                        @if ($accionable)
                            <div class="relative">
                                <div class="flex items-center justify-between gap-2">
                                    <button type="button" @click="listaAbierta = !listaAbierta"
                                        :aria-expanded="listaAbierta.toString()" aria-haspopup="menu"
                                        aria-label="Elegir gráfica de {{ $segmento['etiqueta'] }}"
                                        class="inline-flex min-w-0 items-center gap-2 rounded-md px-1 py-1 text-left transition hover:bg-[#F7F3EC] focus:outline-none focus:ring-2 focus:ring-[#651F34]">
                                        <span class="h-4 w-4 shrink-0 rounded-full ring-1 ring-inset ring-slate-300"
                                            style="background-color: {{ $segmento['color'] }}" aria-hidden="true"></span>
                                        <span class="break-words text-slate-600">{{ $segmento['etiqueta'] }}</span>
                                        <svg class="h-4 w-4 shrink-0 text-[#651F34] transition-transform"
                                            :class="{ 'rotate-180': listaAbierta }" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <span class="shrink-0 font-medium tabular-nums text-slate-800">
                                        {{ number_format($segmento['cantidad']) }}
                                        <span class="text-xs font-normal text-slate-500">
                                            ({{ number_format($segmento['porcentaje'], 1) }}%)
                                        </span>
                                    </span>
                                </div>

                                <div x-cloak x-show="listaAbierta" x-transition @click.outside="listaAbierta = false"
                                    role="menu"
                                    class="absolute left-0 top-full z-50 mt-1 w-72 max-w-[calc(100vw-3rem)] overflow-hidden rounded-xl border border-[#E7DFD9] bg-[#FFFCFA] p-2 shadow-2xl"
                                    style="z-index: 10001; background-color: #FFFCFA; opacity: 1;">
                                    @foreach ($graficasPorTipo as $claveTipo => $grupo)
                                        @if ($claveTipo === $segmento['clave'])
                                            @foreach ($grupo['graficas'] as $claveGrafica => $graficaOpcion)
                                                @php
                                                    $nombreGrupoJs = $grupo['nombre'];
                                                    $tituloGraficaJs = $graficaOpcion['titulo'];
                                                @endphp
                                                <button type="button" role="menuitem"
                                                    @click="abrirGrafica('{{ $claveTipo }}', @js($nombreGrupoJs), '{{ $claveGrafica }}', @js($tituloGraficaJs)); listaAbierta = false"
                                                    class="block w-full rounded-lg px-3 py-2 text-left transition hover:bg-[#F7F3EC] focus:bg-[#F7F3EC] focus:outline-none">
                                                    <span class="block text-sm font-medium text-slate-800">
                                                        {{ $graficaOpcion['titulo'] }}
                                                    </span>
                                                    <span class="mt-0.5 block text-xs text-slate-500">
                                                        Por {{ $graficaOpcion['criterio'] }}
                                                    </span>
                                                </button>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="flex items-center justify-between gap-2">
                                <span class="flex min-w-0 items-center gap-2">
                                    <span class="h-4 w-4 shrink-0 rounded-full ring-1 ring-inset ring-slate-300"
                                        style="background-color: {{ $segmento['color'] }}" aria-hidden="true"></span>
                                    <span class="break-words text-slate-600">{{ $segmento['etiqueta'] }}</span>
                                </span>
                                <span class="shrink-0 font-medium tabular-nums text-slate-800">
                                    {{ number_format($segmento['cantidad']) }}
                                    <span class="text-xs font-normal text-slate-500">
                                        ({{ number_format($segmento['porcentaje'], 1) }}%)
                                    </span>
                                </span>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-slate-500">Sin registros para mostrar.</p>
        @endif
    </div>
</article>

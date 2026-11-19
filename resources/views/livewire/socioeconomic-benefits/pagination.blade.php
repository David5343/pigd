<div class="mt-4 flex flex-col items-center justify-between gap-4 rounded-xl border border-[#E7DFD9] bg-white px-4 py-3 shadow-sm sm:flex-row">
    @if ($paginator->total() > 0)
        <p class="text-sm text-slate-600">
            Mostrando
            <span class="font-semibold text-slate-900">{{ number_format($paginator->firstItem(), 0, '.', ',') }}</span>
            a
            <span class="font-semibold text-slate-900">{{ number_format($paginator->lastItem(), 0, '.', ',') }}</span>
            de
            <span class="font-semibold text-slate-900">{{ number_format($paginator->total(), 0, '.', ',') }}</span>
            resultados
        </p>
    @endif

    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Paginación de titulares" class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="Anterior"
                    class="inline-flex h-9 items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 px-3 text-sm font-medium text-slate-400">
                    Anterior
                </span>
            @else
                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                    wire:loading.attr="disabled" aria-label="Anterior"
                    class="inline-flex h-9 items-center gap-1 rounded-lg border border-[#651F34]/20 bg-white px-3 text-sm font-medium text-[#651F34] transition hover:border-[#651F34] hover:bg-[#651F34] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#651F34]/40 disabled:opacity-50">
                    Anterior
                </button>
            @endif

            <div class="flex items-center gap-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span aria-disabled="true"
                            class="inline-flex h-9 min-w-9 items-center justify-center px-2 text-sm text-slate-400">
                            {{ $element }}
                        </span>
                    @elseif (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                    class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-[#651F34] px-3 text-sm font-semibold text-white shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    wire:loading.attr="disabled" aria-label="Ir a la página {{ $page }}"
                                    class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-transparent px-3 text-sm font-medium text-slate-600 transition hover:border-[#651F34]/20 hover:bg-[#651F34]/10 hover:text-[#651F34] focus:outline-none focus:ring-2 focus:ring-[#651F34]/40 disabled:opacity-50">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                    wire:loading.attr="disabled" aria-label="Siguiente"
                    class="inline-flex h-9 items-center gap-1 rounded-lg border border-[#651F34]/20 bg-white px-3 text-sm font-medium text-[#651F34] transition hover:border-[#651F34] hover:bg-[#651F34] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#651F34]/40 disabled:opacity-50">
                    Siguiente
                </button>
            @else
                <span aria-disabled="true" aria-label="Siguiente"
                    class="inline-flex h-9 items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 px-3 text-sm font-medium text-slate-400">
                    Siguiente
                </span>
            @endif
        </nav>
    @endif
</div>

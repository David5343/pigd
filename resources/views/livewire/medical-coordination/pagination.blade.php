<div class="mt-4 flex flex-col items-center justify-between gap-4 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm sm:flex-row">
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
        <nav role="navigation" aria-label="Paginación de resultados" class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="Anterior"
                    class="inline-flex h-9 items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 px-3 text-sm font-medium text-slate-400">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.79 5.23a.75.75 0 0 1-.02 1.06L8.56 10l4.21 3.71a.75.75 0 1 1-.99 1.12l-4.8-4.23a.75.75 0 0 1 0-1.13l4.75-4.25a.75.75 0 0 1 1.06.02Z"
                            clip-rule="evenodd" />
                    </svg>
                    Anterior
                </span>
            @else
                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                    wire:loading.attr="disabled" aria-label="Anterior"
                    class="inline-flex h-9 items-center gap-1 rounded-lg border border-[#075e56]/20 bg-white px-3 text-sm font-medium text-[#075e56] transition hover:border-[#075e56] hover:bg-[#075e56] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#075e56]/40 disabled:opacity-50">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.79 5.23a.75.75 0 0 1-.02 1.06L8.56 10l4.21 3.71a.75.75 0 1 1-.99 1.12l-4.8-4.23a.75.75 0 0 1 0-1.13l4.75-4.25a.75.75 0 0 1 1.06.02Z"
                            clip-rule="evenodd" />
                    </svg>
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
                                    class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-[#075e56] px-3 text-sm font-semibold text-white shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    wire:loading.attr="disabled" aria-label="Ir a la página {{ $page }}"
                                    class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-transparent px-3 text-sm font-medium text-slate-600 transition hover:border-[#075e56]/20 hover:bg-[#075e56]/10 hover:text-[#075e56] focus:outline-none focus:ring-2 focus:ring-[#075e56]/40 disabled:opacity-50">
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
                    class="inline-flex h-9 items-center gap-1 rounded-lg border border-[#075e56]/20 bg-white px-3 text-sm font-medium text-[#075e56] transition hover:border-[#075e56] hover:bg-[#075e56] hover:text-white focus:outline-none focus:ring-2 focus:ring-[#075e56]/40 disabled:opacity-50">
                    Siguiente
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.21 14.77a.75.75 0 0 1 .02-1.06L11.44 10 7.23 6.29a.75.75 0 1 1 .99-1.12l4.8 4.23a.75.75 0 0 1 0 1.13l-4.75 4.25a.75.75 0 0 1-1.06-.02Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @else
                <span aria-disabled="true" aria-label="Siguiente"
                    class="inline-flex h-9 items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 px-3 text-sm font-medium text-slate-400">
                    Siguiente
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.21 14.77a.75.75 0 0 1 .02-1.06L11.44 10 7.23 6.29a.75.75 0 1 1 .99-1.12l4.8 4.23a.75.75 0 0 1 0 1.13l-4.75 4.25a.75.75 0 0 1-1.06-.02Z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </nav>
    @endif
</div>

{{-- Blade Presentation --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2 mt-8">
        @if ($paginator->onFirstPage())
            <span class="w-10 h-10 flex items-center justify-center rounded-full text-slate-300 text-sm cursor-not-allowed">
                &lsaquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-10 h-10 flex items-center justify-center rounded-full border border-slate-200 text-slate-700 text-sm hover:bg-slate-200 transition">
                &lsaquo;
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="w-10 h-10 flex items-center justify-center rounded-full text-slate-400 text-sm">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="w-10 h-10 flex items-center justify-center rounded-full bg-amber-600 text-white text-sm font-semibold">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-full border border-slate-200 text-slate-700 text-sm hover:bg-slate-200 transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-10 h-10 flex items-center justify-center rounded-full border border-slate-200 text-slate-700 text-sm hover:bg-slate-200 transition">
                &rsaquo;
            </a>
        @else
            <span class="w-10 h-10 flex items-center justify-center rounded-full text-slate-300 text-sm cursor-not-allowed">
                &rsaquo;
            </span>
        @endif
    </nav>
@endif

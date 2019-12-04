@if ($paginator->hasPages())
    <nav class="blog-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="btn btn-outline-secondary disabled" href="#"><span>@lang('pagination.previous')</span></a>
        @else
            <a class="btn btn-outline-primary" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="btn btn-outline-primary" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
        @else
            <a class="btn btn-outline-secondary disabled" href="#"><span>@lang('pagination.next')</span></a>
        @endif
    </nav>
@endif

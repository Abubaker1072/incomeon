@if ($paginator->hasPages())
    <nav class="mp-pagination" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span>&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">&laquo;</a>
        @endif
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
                <span class="active">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">&raquo;</a>
        @else
            <span>&raquo;</span>
        @endif
    </nav>
@endif

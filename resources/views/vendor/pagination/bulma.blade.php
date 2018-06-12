@if ($paginator->hasPages())
    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
        {{-- Previous Page Link --}}
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-previous" rel="prev" aria-label="@lang('pagination.previous')"{{ $paginator->onFirstPage() ? ' disabled' : '' }}>&lsaquo;</a>
        {{-- Next Page Link --}}
        <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next" rel="next" aria-label="@lang('pagination.next')"{{ $paginator->hasMorePages() ? '' : ' disabled' }}>&rsaquo;</a>

        {{-- Pagination Elements --}}
        <ul class="pagination-list">
            
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li><a href="{{ $url }}"class="pagination-link{{ $page == $paginator->currentPage() ? ' is-current' : '' }}">{{ $page }}</a></li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif

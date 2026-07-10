@if ($paginator->hasPages())
    <div class="d-flex justify-content-center mt-20">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="paginate_button page-item previous disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a href="#" class="page-link">Previous</a>
                </li>
            @else
                <li class="paginate_button page-item previous">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link" aria-label="@lang('pagination.previous')">Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="paginate_button page-item disabled">
                        <a href="#" class="page-link">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="paginate_button page-item active" aria-current="page">
                                <a href="#" class="page-link">{{ $page }}</a>
                            </li>
                        @else
                            <li class="paginate_button page-item">
                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="paginate_button page-item next">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next" aria-label="@lang('pagination.next')">Next</a>
                </li>
            @else
                <li class="paginate_button page-item next disabled">
                    <a href="#" class="page-link" aria-disabled="true" aria-label="@lang('pagination.next')">Next</a>
                </li>
            @endif
        </ul>
    </div>
@endif

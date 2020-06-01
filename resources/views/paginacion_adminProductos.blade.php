@if ($todos_productos->hasPages())
    <ul class="pagination pagination">
        {{-- Previous Page Link --}}
        @if ($todos_productos->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $todos_productos->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @if($todos_productos->currentPage() > 3)
            <li class="hidden-xs"><a href="{{ $todos_productos->url(1) }}">1</a></li>
        @endif
        @if($todos_productos->currentPage() > 4)
            <li class="disabled hidden-xs"><span>...</span></li>
        @endif
        @foreach(range(1, $todos_productos->lastPage()) as $i)
            @if($i >= $todos_productos->currentPage() - 2 && $i <= $todos_productos->currentPage() + 2)
                @if ($i == $todos_productos->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $todos_productos->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($todos_productos->currentPage() < $todos_productos->lastPage() - 3)
            <li class="disabled hidden-xs"><span>...</span></li>
        @endif
        @if($todos_productos->currentPage() < $todos_productos->lastPage() - 2)
            <li class="hidden-xs"><a href="{{ $todos_productos->url($todos_productos->lastPage()) }}">{{ $todos_productos->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($todos_productos->hasMorePages())
            <li><a href="{{ $todos_productos->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
@if ($todas_sesiones->hasPages())
    <ul class="pagination pagination">
        {{-- Previous Page Link --}}
        @if ($todas_sesiones->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $todas_sesiones->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @if($todas_sesiones->currentPage() > 3)
            <li class="hidden-xs"><a href="{{ $todas_sesiones->url(1) }}">1</a></li>
        @endif
        @if($todas_sesiones->currentPage() > 4)
            <li class="disabled hidden-xs"><span>...</span></li>
        @endif
        @foreach(range(1, $todas_sesiones->lastPage()) as $i)
            @if($i >= $todas_sesiones->currentPage() - 2 && $i <= $todas_sesiones->currentPage() + 2)
                @if ($i == $todas_sesiones->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $todas_sesiones->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($todas_sesiones->currentPage() < $todas_sesiones->lastPage() - 3)
            <li class="disabled hidden-xs"><span>...</span></li>
        @endif
        @if($todas_sesiones->currentPage() < $todas_sesiones->lastPage() - 2)
            <li class="hidden-xs"><a href="{{ $todas_sesiones->url($todas_sesiones->lastPage()) }}">{{ $todas_sesiones->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($todas_sesiones->hasMorePages())
            <li><a href="{{ $todas_sesiones->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
@if ($todas_salas->hasPages())
    <ul class="pagination pagination">
        {{-- Previous Page Link --}}
        @if ($todas_salas->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $todas_salas->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @if($todas_salas->currentPage() > 3)
            <li class="hidden-xs"><a href="{{ $todas_salas->url(1) }}">1</a></li>
        @endif
        @if($todas_salas->currentPage() > 4)
            <li class="disabled hidden-xs"><span>...</span></li>
        @endif
        @foreach(range(1, $todas_salas->lastPage()) as $i)
            @if($i >= $todas_salas->currentPage() - 2 && $i <= $todas_salas->currentPage() + 2)
                @if ($i == $todas_salas->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $todas_salas->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($todas_salas->currentPage() < $todas_salas->lastPage() - 3)
            <li class="disabled hidden-xs"><span>...</span></li>
        @endif
        @if($todas_salas->currentPage() < $todas_salas->lastPage() - 2)
            <li class="hidden-xs"><a href="{{ $todas_salas->url($todas_salas->lastPage()) }}">{{ $todas_salas->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($todas_salas->hasMorePages())
            <li><a href="{{ $todas_salas->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
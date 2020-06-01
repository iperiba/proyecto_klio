@if ($todas_peliculas->hasPages())
        <ul class="pagination pagination">
                {{-- Previous Page Link --}}
                @if ($todas_peliculas->onFirstPage())
                        <li class="disabled"><span>&laquo;</span></li>
                @else
                        <li><a href="{{ $todas_peliculas->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                @endif

                @if($todas_peliculas->currentPage() > 3)
                        <li class="hidden-xs"><a href="{{ $todas_peliculas->url(1) }}">1</a></li>
                @endif
                @if($todas_peliculas->currentPage() > 4)
                        <li class="disabled hidden-xs"><span>...</span></li>
                @endif
                @foreach(range(1, $todas_peliculas->lastPage()) as $i)
                        @if($i >= $todas_peliculas->currentPage() - 2 && $i <= $todas_peliculas->currentPage() + 2)
                                @if ($i == $todas_peliculas->currentPage())
                                        <li class="active"><span>{{ $i }}</span></li>
                                @else
                                        <li><a href="{{ $todas_peliculas->url($i) }}">{{ $i }}</a></li>
                                @endif
                        @endif
                @endforeach
                @if($todas_peliculas->currentPage() < $todas_peliculas->lastPage() - 3)
                        <li class="disabled hidden-xs"><span>...</span></li>
                @endif
                @if($todas_peliculas->currentPage() < $todas_peliculas->lastPage() - 2)
                        <li class="hidden-xs"><a href="{{ $todas_peliculas->url($todas_peliculas->lastPage()) }}">{{ $todas_peliculas->lastPage() }}</a></li>
                @endif

                {{-- Next Page Link --}}
                @if ($todas_peliculas->hasMorePages())
                        <li><a href="{{ $todas_peliculas->nextPageUrl() }}" rel="next">&raquo;</a></li>
                @else
                        <li class="disabled"><span>&raquo;</span></li>
                @endif
        </ul>
@endif
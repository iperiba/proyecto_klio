@if (isset($todas_peliculas))
    @if ($todas_peliculas->hasPages())
        <ul class="pagination pagination">
            {{-- Previous Page Link --}}
            @if ($todas_peliculas->onFirstPage())
                <li class="disabled"><span class="page-number">&laquo;</span></li>
            @else
                <li><a class="page-number" href="{{ $todas_peliculas->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            @if($todas_peliculas->currentPage() > 3)
                <li class="hidden-xs"><a class="page-number" href="{{ $todas_peliculas->url(1) }}">1</a></li>
            @endif
            @if($todas_peliculas->currentPage() > 4)
                <li class="disabled hidden-xs"><span class="page-number">...</span></li>
            @endif
            @foreach(range(1, $todas_peliculas->lastPage()) as $i)
                @if($i >= $todas_peliculas->currentPage() - 2 && $i <= $todas_peliculas->currentPage() + 2)
                    @if ($i == $todas_peliculas->currentPage())
                        <li class="active"><span class="page-number">{{ $i }}</span></li>
                    @else
                        <li><a class="page-number" href="{{ $todas_peliculas->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach
            @if($todas_peliculas->currentPage() < $todas_peliculas->lastPage() - 3)
                <li class="disabled hidden-xs"><span class="page-number">...</span></li>
            @endif
            @if($todas_peliculas->currentPage() < $todas_peliculas->lastPage() - 2)
                <li class="hidden-xs"><a class="page-number" href="{{ $todas_peliculas->url($todas_peliculas->lastPage()) }}">{{ $todas_peliculas->lastPage() }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($todas_peliculas->hasMorePages())
                <li><a class="page-number" href="{{ $todas_peliculas->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="disabled"><span class="page-number">&raquo;</span></li>
            @endif
        </ul>
    @endif
@elseif(isset($peliculas_genero))
    @if ($peliculas_genero->hasPages())
        <ul class="pagination pagination">
            {{-- Previous Page Link --}}
            @if ($peliculas_genero->onFirstPage())
                <li class="disabled"><span class="page-number">&laquo;</span></li>
            @else
                <li><a class="page-number" href="{{ $peliculas_genero->previousPageUrl()."&select_genero=".$genero_escogido }}" rel="prev">&laquo;</a></li>
            @endif

            @if($peliculas_genero->currentPage() > 3)
                <li class="hidden-xs"><a class="page-number" href="{{ $peliculas_genero->url(1)."&select_genero=".$genero_escogido }}">1</a></li>
            @endif
            @if($peliculas_genero->currentPage() > 4)
                <li class="disabled hidden-xs"><span class="page-number">...</span></li>
            @endif
            @foreach(range(1, $peliculas_genero->lastPage()) as $i)
                @if($i >= $peliculas_genero->currentPage() - 2 && $i <= $peliculas_genero->currentPage() + 2)
                    @if ($i == $peliculas_genero->currentPage())
                        <li class="active"><span class="page-number">{{ $i }}</span></li>
                    @else
                        <li><a class="page-number" href="{{ $peliculas_genero->url($i)."&select_genero=".$genero_escogido }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach
            @if($peliculas_genero->currentPage() < $peliculas_genero->lastPage() - 3)
                <li class="disabled hidden-xs"><span class="page-number">...</span></li>
            @endif
            @if($peliculas_genero->currentPage() < $peliculas_genero->lastPage() - 2)
                <li class="hidden-xs"><a class="page-number" href="{{ $peliculas_genero->url($peliculas_genero->lastPage())."&select_genero=".$genero_escogido }}">{{ $peliculas_genero->lastPage() }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($peliculas_genero->hasMorePages())
                <li><a class="page-number" href="{{ $peliculas_genero->nextPageUrl()."&select_genero=".$genero_escogido }}" rel="next">&raquo;</a></li>
            @else
                <li class="disabled"><span class="page-number">&raquo;</span></li>
            @endif
        </ul>
    @endif
@endif
    <!--<div class="pagination">
        <a href="#" class="page-number prev"><i class="fa fa-angle-left"></i></a>
        <span class="page-number current">1</span>
        <a href="#" class="page-number">2</a>
        <a href="#" class="page-number">3</a>
        <a href="#" class="page-number">4</a>
        <a href="#" class="page-number">5</a>
        <a href="#" class="page-number next"><i class="fa fa-angle-right"></i></a>
    </div>-->
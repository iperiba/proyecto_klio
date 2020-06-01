@extends('layouts.app')

@section('css_adicional')
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('pagina')

    <?php
            $array_generos = array("Romance", "Ciencia ficción", "Acción", "Comedia", "Drama", "Musical", "Terror", "Suspense", "Bélico",
                "Histórico", "Animación", "Autor");
    ?>

    <div id="site-content">
        <header class="site-header">
            <div class="container">

                @include('menu_cine')

                <div class="mobile-navigation"></div>
            </div>
        </header>
        <main class="main-content">
            <div class="container">
                <div class="page">
                    <div class="breadcrumbs">
                        <a href="{{ route('home') }}">Home</a>
                        <span>Movie Review</span>
                    </div>
                    <div class="filters">
                        <form id="seleccion_pelicula" method="GET" action="{{ route('review_seleccionada') }}">
                            @csrf
                            <select id="select_genero" name="select_genero" onchange="this.form.submit()">
                                @foreach ($array_generos as $genero)
                                        <option value="{{$genero}}"
                                        <?php
                                            if (isset($genero_escogido)) {
                                                if ($genero==$genero_escogido) {
                                                    echo "selected";
                                                }
                                            }
                                        ?>
                                        >{{$genero}}
                                        </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="movie-list">
                        @if (isset($todas_peliculas))
                            @foreach ($todas_peliculas as $pelicula)
                                <div class="movie">
                                    <figure class="movie-poster">
                                        <img src="{{url(str_replace("images", "cropImages3", $pelicula->cartel))}}" alt="Slide">
                                    </figure>
                                    <div class="movie-title">
                                        <a href="{{route('single', ['id' => $pelicula->id]) }}">{{$pelicula->titulo}}</a>
                                    </div>
                                    <p>
                                    <?php
                                    echo implode(' ', array_slice(explode(' ', $pelicula->sinopsis), 0, 15))."...";
                                    ?>
                                </div>
                            @endforeach
                        @elseif (isset($peliculas_genero))
                            @foreach ($peliculas_genero as $pelicula)
                                <div class="movie">
                                    <figure class="movie-poster">
                                        <img src="{{url(str_replace("images", "cropImages3", $pelicula->cartel))}}" alt="Slide">
                                    </figure>
                                    <div class="movie-title">
                                        <a href="{{route('single', ['id' => $pelicula->id]) }}">{{$pelicula->titulo}}</a>
                                    </div>
                                    <p>
                                    <?php
                                    echo implode(' ', array_slice(explode(' ', $pelicula->sinopsis), 0, 15))."...";
                                    ?>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @include('paginacion_review')
                    <!--<div class="pagination">
                        <a href="#" class="page-number prev"><i class="fa fa-angle-left"></i></a>
                        <span class="page-number current">1</span>
                        <a href="#" class="page-number">2</a>
                        <a href="#" class="page-number">3</a>
                        <a href="#" class="page-number">4</a>
                        <a href="#" class="page-number">5</a>
                        <a href="#" class="page-number next"><i class="fa fa-angle-right"></i></a>
                    </div>-->

                </div>
            </div> <!-- .container -->
        </main>
        @include('footer_cine');
    </div>
@endsection
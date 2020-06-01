@extends('layouts.app')

@section('css_adicional')
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .cuadrante_sesion {
            margin-top: 50px;
        }

        .contenedor_sesiones{
            margin-top: -40px;
            margin-left: 1px;
        }

        .content {
            margin-bottom: 30px;
        }

    </style>
@endsection

@section('pagina')
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
                        <a href="{{ route('review_general') }}">Movie Review</a>
                        <span>{{ $pelicula->titulo }}</span>
                    </div>

                    <div class="content">
                        <div class="row">
                            <div class="col-md-6">
                                <figure class="movie-poster"><img src="{{ url($pelicula->cartel) }}" alt="{{ $pelicula->titulo }}"></figure>
                            </div>
                            <div class="col-md-6">
                                <h2 class="movie-title">{{ $pelicula->titulo }}</h2>
                                <div class="movie-summary">
                                    {{ $pelicula->sinopsis }}
                                </div>
                                <ul class="movie-meta modificacion_primer_bloque">
                                    <li><strong>Rating:</strong>
                                        <div class="star-rating" title="Rated 4.00 out of 5"><span style="width:80%"><strong class="rating">4.00</strong> out of 5</span></div>
                                    </li>
                                    <li><strong>Duración:</strong>{{ $pelicula->duracion }} min</li>

                                    <?php
                                    date_default_timezone_set('Europe/Madrid');
                                    setlocale(LC_TIME, 'es_ES.UTF-8');
                                    setlocale(LC_TIME, 'spanish');
                                    ?>

                                    <li><strong>Estreno:</strong> {{ strftime("%B de %Y", strtotime($pelicula->estreno)) }} (USA)</li>
                                    <li><strong>Categorías:</strong> {{ $pelicula->categorias }}</li>
                                </ul>

                                <ul class="starring">
                                    <li><strong>Director/a:</strong> {{ $pelicula->director }}</li>
                                    <li><strong>Guionistas:</strong> {{ $pelicula->guionistas }}</li>
                                    <li><strong>Actores:</strong> {{ $pelicula->actores }}</li>
                                </ul>
                            </div>
                        </div> <!-- .row -->
                        <!--<div class="entry-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac pharetra libero. Integer in suscipit diam, sit amet eleifend nunc. Curabitur egestas nunc nulla, in aliquet risus efficitur quis. Vivamus facilisis est libero, vitae iaculis nulla cursus in. Suspendisse potenti. In et fringilla ipsum, quis varius quam. Morbi eleifend venenatis diam finibus vehicula. Suspendisse eu blandit metus. Sed feugiat pellentesque turpis, in lacinia ipsum. Vivamus nec luctus orci.</p>
                            <p>Aenean vehicula eget risus sit amet posuere. Maecenas id risus maximus, malesuada leo eget, pellentesque arcu. Phasellus vitae leo rhoncus, consectetur mauris vitae, lacinia quam. Nunc turpis erat, accumsan eget justo quis, auctor ultricies magna. Mauris sodales, risus sit amet hendrerit tincidunt, erat ante facilisis sapien, sit amet maximus neque massa a felis. Nullam consectetur justo massa, vel commodo metus gravida in. Aliquam erat volutpat. Nullam a lorem sed lorem euismod gravida a eu velit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec venenatis ac ligula vel pharetra. Aenean vitae nulla sed dui volutpat euismod. Nam ex quam, consequat id rutrum sed, porttitor id lectus. Vestibulum venenatis consectetur justo ut sagittis. Duis dignissim tincidunt quam, nec pulvinar libero luctus nec. Morbi blandit nec lorem in ullamcorper.</p>
                            <p>Vestibulum et odio massa. Integer at odio ipsum. Proin vitae tristique nibh. Aenean semper ante sit amet ante ultricies tincidunt. Curabitur cursus, urna non ultricies posuere, dolor lacus cursus lorem, a dapibus nibh ex eget sem. Aliquam semper sagittis sapien a fermentum. Nullam sed iaculis lacus, et imperdiet risus. Praesent quis turpis ac nunc sodales tincidunt. Aliquam at leo odio. Sed a tempor nisl, et mattis felis. Nam mauris nunc, commodo ac orci ut, auctor viverra mauris.</p>
                            <p>Quisque nec justo vitae metus consectetur ultrices. Duis venenatis lorem massa, eu pulvinar quam faucibus sed. Nulla fringilla lorem sit amet sagittis mattis. Nunc in leo a odio mollis consectetur. Etiam ac nisl eget diam ullamcorper porta. Aliquam consectetur neque eget metus egestas sollicitudin. Curabitur ultrices urna et feugiat malesuada.</p>
                            <p>Nulla facilisi. Fusce sed dapibus leo, eu lobortis ante. Duis luctus mauris in ante semper, ut feugiat nisi condimentum. Nullam a odio et justo suscipit tempus. Vestibulum placerat dapibus quam, a egestas turpis efficitur id. Integer suscipit placerat placerat. Phasellus in lorem quis leo egestas accumsan. Nam et euismod ligula. Duis nec erat aliquam, sollicitudin diam non, ornare leo. Pellentesque augue leo, faucibus in nunc nec, tincidunt ullamcorper tortor. Phasellus aliquam condimentum elit. Nulla facilisi. Donec magna libero, bibendum eu faucibus et, mattis at felis. Integer turpis nibh, blandit nec elit vel, euismod laoreet quam. Donec vel ante nisi. Nunc luctus a tellus non.</p>
                        </div>-->
                        <div class="row contenedor_sesiones">
                            <?php
                            for ($x = 0; $x < sizeof($sesiones_5dias); $x++) {
                                $date = strtotime($sesiones_5dias[$x]->fecha);
                                $fecha = date('d-M-Y', $date);
                                $hora = date('H:i:s', $date);
                                //Pinta los dias de las sesiones. Si un dia es igual en las distintas sesiones, no pinta el dia
                            ?>
                                <div class="cuadrante_sesion col-sm-3">
                                    <p><b>{{$fecha}}</b></p>
                                    <p>Hora: {{$hora}}</p>
                                    <p>Sala: {{ $sesiones_5dias[$x]->sala }}</p>
                                    <form method="post" action="{{ route('seleccion_asientos01') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id_sesion" value="{{ $sesiones_5dias[$x]->id }}">
                                        <button type="submit" class="btn btn-primary">Reservar asientos</button>
                                    </form>
                                </div>
                            <?php
                            }
                            ?>
                        </div><!-- .row .contenedor_sesiones -->
                    </div><!-- .content -->
                </div><!-- .page -->
            </div> <!-- .container -->
        </main>
        @include('footer_cine');
    </div>
@endsection
@extends('layouts.app')

@section('css_adicional')
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .vividworknav {
            /*width: 33.333%;*/
            height: auto;
            /*float: left;*/
            padding: 0;
            position: relative;
            background-color: black;
        }

        .vividworknav:hover img {
            opacity: 0.3;
        }

        .vividworknav:hover .work-text-content {
            opacity: 1;
        }

        .vividworknav img {
            padding: 0;
            width: 100%;
            display: block;
            opacity: 1;
        }

        .vividworknav img,
        .work-text-content {
            -webkit-transition: opacity 0.5s ease-out;
            -moz-transition: opacity 0.5s ease-out;
            -o-transition: opacity 0.5s ease-out;
            transition: opacity 0.5s ease-out;
        }

        .work-text-content {
            position: absolute;
            color: white;
            left: 0;
            top: 15%;
            right: 0;
            bottom: 0;
            font-size: 24px;
            text-align: center;
            opacity: 0;
        }
    </style>
@endsection

@section('pagina')

<!-- Cinema template -->
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
                <div class="row">
                    <div class="col-md-9">
                        <div class="slider">
                            <ul class="slides">
                                @isset($ultimas_tres_peliculas)
                                    @foreach ($ultimas_tres_peliculas as $ultima_pelicula)
                                        <li>
                                            <div class="vividworknav">
                                                <a href="{{route('single', ['id' => $ultima_pelicula->id]) }}">
                                                    <img src="{{url(str_replace("images", "cropImages", $ultima_pelicula->cartel))}}" alt="Slide">
                                                    <div class="work-text-content" style="top:37%;">
                                                        <p>{{$ultima_pelicula->titulo}}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                @endisset
                                <!--<li><a href="#"><img src="dummy/slide-1.jpg" alt="Slide 1"></a></li>
                                <li><a href="#"><img src="dummy/slide-2.jpg" alt="Slide 2"></a></li>
                                <li><a href="#"><img src="dummy/slide-3.jpg" alt="Slide 3"></a></li>-->
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            @isset($dos_peliculas)
                                @foreach ($dos_peliculas as $pelicula_dos)
                                    <div class="col-sm-6 col-md-12">
                                        <div class="latest-movie">
                                            <div class="vividworknav">
                                                <a href="{{route('single', ['id' => $pelicula_dos->id]) }}">
                                                    <img src="{{url(str_replace("images", "cropImages2", $pelicula_dos->cartel))}}" alt="Slide">
                                                    <div class="work-text-content" style="top:25%;">
                                                        <p>{{$pelicula_dos->titulo}}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endisset
                            <!--<div class="col-sm-6 col-md-12">
                                <div class="latest-movie">
                                    <a href="#"><img src="dummy/thumb-1.jpg" alt="Movie 1"></a>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-12">
                                <div class="latest-movie">
                                    <a href="#"><img src="dummy/thumb-2.jpg" alt="Movie 2"></a>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div> <!-- .row -->
                <div class="row">
                    @isset($cuatro_peliculas)
                        @foreach ($cuatro_peliculas as $pelicula_cuatro)
                            <div class="col-sm-6 col-md-3">
                                <div class="latest-movie">
                                    <div class="vividworknav">
                                        <a href="{{route('single', ['id' => $pelicula_cuatro->id]) }}">
                                            <img src="{{url(str_replace("images", "cropImages2", $pelicula_cuatro->cartel))}}" alt="Slide">
                                            <div class="work-text-content" style="top:25%;">
                                                <p>{{$pelicula_cuatro->titulo}}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                    <!--<div class="col-sm-6 col-md-3">
                        <div class="latest-movie">
                            <a href="#"><img src="dummy/thumb-3.jpg" alt="Movie 3"></a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="latest-movie">
                            <a href="#"><img src="dummy/thumb-4.jpg" alt="Movie 4"></a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="latest-movie">
                            <a href="#"><img src="dummy/thumb-5.jpg" alt="Movie 5"></a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="latest-movie">
                            <a href="#"><img src="dummy/thumb-6.jpg" alt="Movie 6"></a>
                        </div>
                    </div>-->
                </div> <!-- .row -->

                <div class="row">
                    <div class="col-md-4">
                        <h2 class="section-title">December premiere</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
                        <ul class="movie-schedule">
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                        </ul> <!-- .movie-schedule -->
                    </div>
                    <div class="col-md-4">
                        <h2 class="section-title">November premiere</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
                        <ul class="movie-schedule">
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                        </ul> <!-- .movie-schedule -->
                    </div>
                    <div class="col-md-4">
                        <h2 class="section-title">October premiere</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
                        <ul class="movie-schedule">
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                            <li>
                                <div class="date">16/12</div>
                                <h2 class="entry-title"><a href="#">Perspiciatis unde omnis</a></h2>
                            </li>
                        </ul> <!-- .movie-schedule -->
                    </div>
                </div>
            </div>
        </div> <!-- .container -->
    </main>
    @include('footer_cine');
</div>
<!-- Default snippet for navigation -->
@endsection

@section('js_adicional')
@endsection
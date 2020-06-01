<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css_adicional')
    <script>
    </script>
</head>
<body>
    <div id="app">
        @yield('menu_login')

        <!-- Inicio menu administrador-->
        @if (Auth::check())
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Gestión Klío</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin_peliculas')}}">Películas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin_salas')}}">Salas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin_sesiones')}}">Sesiones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin_productos')}}">Productos</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a style="color: darkred !important;" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                Desconectarse
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
                <div>
                <a class="btn btn-info" href="{{ route('home') }}">Volver a la home</a>
                </div>
            </div>
        </nav>
    @endif
    <!-- Fin menu administrador-->
    @yield('content')
    @yield('pagina')

    </div>
    <script src="{{ asset('js/ie-support/html5.js') }}"></script>
    <script src="{{ asset('js/ie-support/respond.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/app2.js') }}"></script>
    @yield('js_adicional')
</body>
</html>

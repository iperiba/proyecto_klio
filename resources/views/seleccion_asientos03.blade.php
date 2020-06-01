@extends('layouts.app')

@section('css_adicional')
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('js_adicional')
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
                    <div class="content">
                        <p>Sus entradas han sido enviadas a {{ $email }}</p>
                        <p>Gracias por confiar en nuestros servicios</p>
                        <a href="{{ URL::route('home') }}" class="btn btn-info"> Volver al inicio </a>
                    </div>
                </div>
            </div> <!-- .container -->
        </main>
        @include('footer_cine');
    </div>
@endsection
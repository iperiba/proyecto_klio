@extends('layouts.app')

@section('css_adicional')
    <style>
        .container {
            padding-right: 0px;
            padding-left: 0px;
            margin-right: 0px;
            margin-left: 50px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .pagination {
            width: 1px;
            margin: auto;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .pagination li {
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        @include('paginacion_adminPeliculas')

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Título</th>
                <th scope="col">Director</th>
                <!--<th scope="col">Guionistas</th>-->
                <th scope="col">Actores</th>
                <th scope="col">Categorías</th>
                <th scope="col">Cartel</th>
                <!--<th scope="col">sinopsis</th>-->
                <!--<th scope="col">trailer</th>-->
                <th scope="col">Duración</th>
                <th scope="col">Fecha estreno</th>
                <!--<th scope="col">Fecha incorporación</th>
                <th scope="col">Fecha modificación</th>-->
                <th scope="col">Editar</th>
                <th scope="col">Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($todas_peliculas as $pelicula)
                <tr>
                    @foreach ($pelicula->toArray() as $key => $value)
                        @if ($key != 'id' && $key != 'guionistas' && $key != 'sinopsis' && $key != 'en_cartelera' &&
                        $key != 'trailer' && $key != 'created_at' && $key != 'updated_at')
                            @if ($key == 'cartel')
                                <td><img style="width: 100px;" src="{{url($value)}}"></td>
                            @else
                                <td>{{ $value }}</td>
                           @endif
                       @endif
                   @endforeach
                   <td><a class="btn btn-primary" href="{{ route('formulario_pelicula', ['id' => $pelicula->id]) }}" role="button">Editar película</a></td>
                   <td><a class="btn btn-primary" href="{{ route('desactivar_pelicula', ['id' => $pelicula->id]) }}" role="button">Eliminar de cartelera</a></td>
               </tr>
           @endforeach
           </tbody>
       </table>
       <a class="btn btn-primary" href="{{ route('formulario_pelicula') }}" role="button">Añadir película</a>
   </div>
@endsection




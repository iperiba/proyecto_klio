@extends('layouts.app')

@section('css_adicional')
    <style>
        .container {
            padding-right: 0px;
            padding-left: 0px;
            margin-right: 0px;
            margin-left: 20px;
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
        @include('paginacion_adminSalas')
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Código sala</th>
                <th scope="col">Largo</th>
                <th scope="col">Ancho</th>
                <th scope="col">Creada</th>
                <th scope="col">Modificada</th>
                <th scope="col">Editar</th>
                <th scope="col">Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($todas_salas as $sala)
                <tr>
                    @foreach ($sala->toArray() as $key => $value)
                        @if ($key != 'id')
                            <td>{{ $value }}</td>
                        @endif
                    @endforeach
                    <td><a class="btn btn-primary" href="{{ route('formulario_sala', ['id' => $sala->id]) }}" role="button">Editar sala</a></td>
                    <td><a class="btn btn-primary" href="{{ route('eliminar_sala', ['id' => $sala->id]) }}" role="button">Eliminar sala</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a class="btn btn-primary" href="{{ route('formulario_sala') }}" role="button">Añadir sala</a>
    </div>
@endsection


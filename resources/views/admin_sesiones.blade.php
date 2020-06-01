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
        @include('paginacion_adminSesiones')
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Película</th>
                <th scope="col">Sala</th>
                <th scope="col">Fecha</th>
                <th scope="col">Duración</th>
                <th scope="col">Creada</th>
                <th scope="col">Modificada</th>
                <th scope="col">Editar</th>
                <th scope="col">Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($todas_sesiones as $sesion)
                <tr>
                    @foreach ($sesion->toArray() as $key => $value)
                        @if ($key != 'pelicula_id' && $key != 'sala_id' && $key !='id')
                            <td>{{ $value }}</td>
                        @endif
                    @endforeach
                    <!--<td><a class="btn btn-primary" href="{{ route('formulario_sesion', ['id' => $sesion->id]) }}" role="button">Editar sesión</a></td>-->
                    <td>
                        <form action="{{ route('formulario_sesion') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $sesion->id }}">
                            <button class="btn btn-primary" type="submit">Editar</button>
                        </form>
                        <td>
                            <form action="{{ route('formulario_sesion') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $sesion->id }}">
                                <button class="btn btn-primary" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
<form action="{{ route('formulario_sesion') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="0">
    <button class="btn btn-primary" type="submit">Submit</button>
</form>
</div>
@endsection


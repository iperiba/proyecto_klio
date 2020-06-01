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
        @include('paginacion_adminProductos')
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Categoría</th>
                <th scope="col">Foto</th>
                <th scope="col">Fecha incorporación</th>
                <th scope="col">Fecha modificación</th>
                <th scope="col">Editar</th>
                <th scope="col">Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($todos_productos as $producto)
                <tr>
                    @foreach ($producto->toArray() as $key => $value)
                        @if ($key != 'id')
                            @if ($key == 'foto')
                                <td><img style="width: 70px;" src="{{url($value)}}"></td>
                            @else
                                <td>{{ $value }}</td>
                            @endif
                        @endif
                    @endforeach
                    <td>
                        <form action="{{ route('formulario_productos') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $producto->id }}">
                            <button class="btn btn-primary" type="submit">Editar</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('eliminar_producto') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $producto->id }}">
                            <button class="btn btn-primary" type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form action="{{ route('formulario_productos') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="0">
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
@endsection


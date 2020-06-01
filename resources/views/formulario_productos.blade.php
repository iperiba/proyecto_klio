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

        input {
            width: 80% !important;
        }

    </style>
@endsection


@section('content')
    <div class="container">
        <form id="formulario_productos" method="POST" action="{{ route('anadir_modificar_producto') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="<?php if(isset($producto_modificar)){ echo($producto_modificar->id); }else{ echo('0'); } ?>">

                <div class="form-group">
                    <label for="nombre_producto">Nombre producto</label>
                    <input class="form-control" id="nombre_producto" name="nombre_producto" placeholder="Introduzca aquí el nombre del producto"
                           value="<?php if(isset($producto_modificar)){ echo($producto_modificar->nombre); }else{ echo(''); } ?>">
                </div>
                @error('nombre_producto')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror


            <div class="form-group">
                <label for="precio">Precio</label>
                <input min="0" type="number" class="form-control" id="precio" name="precio" placeholder="Introduzca precio del producto"
                       value="<?php if(isset($producto_modificar)){ echo($producto_modificar->precio); }else{ echo(0); } ?>" step="0.1">
            </div>
            @error('precio')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror


            <div class="form-group">
                <label for="categoria" style="margin-right: 10px">Categoría: </label>
                <select id="categoria" name="categoria">
                    <option value="entradas"
                    <?php if(isset($producto_modificar)){
                        if ($producto_modificar->categoria=="entradas") {
                            echo "selected";
                        }
                    } ?>
                    >Entradas</option>

                    <option value="comida"
                    <?php if(isset($producto_modificar)){
                        if ($producto_modificar->categoria=="comida") {
                            echo "selected";
                        }
                    } ?>
                    >Comida</option>

                    <option value="bebida"
                    <?php if(isset($producto_modificar)){
                        if ($producto_modificar->categoria=="bebida") {
                            echo "selected";
                        }
                    } ?>
                    >Bebida</option>
                </select>
            </div>
            @error('categoria')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror


            <div class="form-group">
                <label for="imagen_producto">Imagen</label>
                <input type="file" class="form-control" id="imagen_producto" name="imagen_producto"
                       value="<?php if(isset($producto_modificar)){ echo($producto_modificar->foto); }else{ echo(''); } ?>">
            </div>
            @error('imagen_producto')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn btn-primary">Submit</button>
            @if(Session::has('message'))
                <div style="color: red;">
                    {{ Session::get('message')}}
                </div>
            @endif
        </form>
    </div>
@endsection
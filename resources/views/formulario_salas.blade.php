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
            width: 30% !important;
        }
    </style>
@endsection

@section('content')
    <?php
    ?>
    <div class="container">
        <form id="formulario_sala" method="POST" action="{{ route('anadir_modificar_sala') }}">
            @csrf
            <input type="hidden" name="id" value="<?php if(isset($sala_modificar)){ echo($sala_modificar->id); }else{ echo('0'); } ?>">
            <div class="form-group">
                <label for="titulo">Código Sala</label>
                <input class="form-control" id="codigo_sala" name="codigo_sala" placeholder="Introduzca el código de la sala"
                       value="<?php if(isset($sala_modificar)){ echo($sala_modificar->codigo_sala); }else{ echo(''); } ?>">
            </div>
            @error('codigo_sala')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <label for="director">Largo</label>
                <input min="1" type="number" class="form-control" id="largo" name="largo" placeholder="Introduzca el largo de la sala (en asientos)"
                       value="<?php if(isset($sala_modificar)){ echo($sala_modificar->largo); }else{ echo(''); } ?>">
            </div>
            @error('largo')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <label for="actores">Ancho</label>
                <input min="1" type="number" class="form-control" id="ancho" name="ancho" placeholder="Introduzca el ancho de la sala"
                       value="<?php if(isset($sala_modificar)){ echo($sala_modificar->ancho); }else{ echo(''); } ?>">
            </div>
            @error('ancho')
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
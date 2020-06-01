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

        .bloque_check {
            width: 50%;
            float: left;
        }
    </style>
@endsection

@section('content')
    <?php
    ?>
    <div class="container">
        <form id="formulario_pelicula" method="POST" action="{{ route('anadir_modificar_pelicula') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="<?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->id); }else{ echo('0'); } ?>">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input class="form-control" id="titulo" name="titulo" placeholder="Introduzca un título"
                       value="<?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->titulo); }else{ echo(''); } ?>">
            </div>
            @error('titulo')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <label for="director">Director/a</label>
                <input class="form-control" id="director" name="director" placeholder="Nombre del director/a o los directores -separados por comas-"
                       value="<?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->director); }else{ echo(''); } ?>">
            </div>
            @error('director')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="actores">Guionistas</label>
                <input class="form-control" id="guionistas" name="guionistas" placeholder="Nombre de los guionistas -separados por comas-"
                       value="<?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->guionistas); }else{ echo(''); } ?>">
            </div>
            @error('guionistas')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="actores">Actores</label>
                <input class="form-control" id="actores" name="actores" placeholder="Nombre de los actores -separados por comas-"
                       value="<?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->actores); }else{ echo(''); } ?>">
            </div>
            @error('actores')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <!-- Checkbox -->
            <label>Categorías</label>
            <div style="clear:both;"></div>

            <div class="bloque_check">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria01" value="Romance"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Romance')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria01">
                        Romance
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria02" value="Ciencia ficción"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Ciencia ficción')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria02">
                        Ciencia ficción
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria03" value="Acción"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Acción')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria03">
                        Acción
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria04" value="Comedia"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Comedia')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria04">
                        Comedia
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria05" value="Drama"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Drama')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria05">
                        Drama
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria06" value="Musical"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Musical')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria06">
                        Musical
                    </label>
                </div>
            </div>
            <div class="bloque_check">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria07" value="Terror"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Terror')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria07">
                        Terror
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria08" value="Suspense"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Suspense')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria08">
                        Suspense
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria09" value="Bélico"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Bélico')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria09">
                        Bélico
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria10" value="Histórico"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Histórico')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria10">
                        Histórico
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria11" value="Animación"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Animación')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria11">
                        Animación
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categorias[]" id="categoria12" value="Autor"
                    <?php if(isset($pelicula_modificar)){ if(strpos($pelicula_modificar->categorias, 'Autor')!== false) { echo "checked"; }} ?>>
                    <label class="form-check-label" for="categoria12">
                        Autor
                    </label>
                </div>
            </div>
            <div style="clear: both"></div>
            @error('generos')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <!-- Fin Checkbox -->

            <div class="form-group" style="margin-top: 20px">
                <label for="cartel">Cartel</label>
                <input type="file" class="form-control" id="cartel" name="cartel"
                       value="<?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->cartel); }else{ echo(''); } ?>">
            </div>
            @error('cartel')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label style="width: 100%; margin-top: 15px;" for="sinopsis">Sinopsis</label>
                <textarea rows="4" cols="50" name="sinopsis" form="formulario_pelicula"><?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->sinopsis); }else{ echo('Escriba la sinopsis de la película aquí...'); } ?></textarea>
            </div>
            @error('sinopsis')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="cartel">Tráiler</label>
                <input type="file" class="form-control" id="trailer" name="trailer"
                       value="<?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->trailer); }else{ echo(''); } ?>">
            </div>
            @error('trailer')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
                <label for="duracion">Duración</label>
                <input type="number" class="form-control" id="duracion" name="duracion"
                       value="<?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->duracion); }else{ echo(''); } ?>">
            </div>
            @error('duracion')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="duracion">Fecha estreno</label>
                <input type="date" class="form-control" id="estreno" name="estreno"
                       value="<?php if(isset($pelicula_modificar)){ echo($pelicula_modificar->estreno); }else{ echo(''); } ?>">
            </div>
            @error('estreno')
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
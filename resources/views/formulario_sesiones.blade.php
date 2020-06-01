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

        label {
            margin-right: 10px;
        }
    </style>
@endsection

@section('js_adicional')
    <script>
        function mostrar_fechas() {
            var id = $("#id").val();
            //var pelicula = $("#pelicula_sesion").val();
            var sala = $("#sala_sesion").val();
            var fecha = $("#fecha_sesion").val();

            if (sala!="" && fecha!=""){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method:'POST',
                    url:'comprobacion_fecha',
                    data: {
                        id:id,
                        //pelicula:pelicula,
                        sala:sala,
                        fecha:fecha,
                    },

                    success:function(data) {
                        console.log(data);
                        if (data.sesiones_existentes.length==0) {
                            $("#horas_ya_ocupadas").html("No hay sesiones que mostrar");
                        } else {
                            var texto = "";
                            var duracion = data.sesiones_existentes[0]["duracion"];
                            for (var i = 0; i < data.sesiones_existentes.length; i++) {
                                let titulo_pelicula = data.sesiones_existentes[i]["titulo"];
                                let fecha_inicio_string = data.sesiones_existentes[i]["fecha"];
                                let fecha_inicio_date01 = new Date(fecha_inicio_string);
                                let fecha_inicio_date02 = new Date(fecha_inicio_string);
                                let fecha_final_date01 = fecha_inicio_date02.setMinutes(fecha_inicio_date02.getMinutes() + duracion);
                                let fecha_final_date02 = new Date(fecha_final_date01);

                                texto += titulo_pelicula + " -> " + fecha_inicio_date01.getHours() + ":" + fecha_inicio_date01.getMinutes()
                                    + " - " + fecha_final_date02.getHours() + ":" + fecha_final_date02.getMinutes() + "<br><br>"
                            }
                            $("#horas_ya_ocupadas").html(texto);
                        }
                    }
                });
            }
        }

        $(document).ready(function() {
            $('#formulario_sesiones').submit(function(e) {
                $.ajax({
                    type: 'POST',
                    url:'comprobaciones_preSubmit',
                    data: $(this).serialize(),
                    success: function(data) {

                        document.getElementById("error_fecha_sesion").style.display = "none";
                        document.getElementById("error_hora_sesion").style.display = "none";

                        if(data.error_fecha_sesion) {
                            document.getElementById("error_fecha_sesion").style.display = "block";
                            document.getElementById("error_fecha_sesion").innerHTML = data.error_fecha_sesion;
                            return false;
                        }

                        if(data.error_hora_sesion) {
                            document.getElementById("error_hora_sesion").style.display = "block";
                            document.getElementById("error_hora_sesion").innerHTML = data.error_hora_sesion;
                            return false;
                        }

                        $("#formulario_sesiones")[0].submit();
                    }
                })
                e.preventDefault();
            });
            mostrar_fechas();
        })

</script>
@endsection

@section('content')
    <div class="container">
        <div id="prueba"></div>
        <form id="formulario_sesiones" method="POST" action="{{ route('anadir_modificar_sesion') }}">
            @csrf
            <input id="id" type="hidden" name="id" value="<?php if(isset($sesion_modificar)){ echo($sesion_modificar->id); }else{ echo('0'); } ?>">

            <div class="form-group">
                <label for="pelicula_sesion">Película</label>
                <select name="pelicula_sesion" id="pelicula_sesion" onchange="mostrar_fechas()">
                    @foreach ($todas_peliculas as $pelicula)
                        <option value="{{ $pelicula->id }}" <?php if(isset($sesion_modificar)){
                            if($sesion_modificar->pelicula_id==$pelicula->id) {
                                echo "selected";
                            }
                        }?>>{{ $pelicula->titulo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="sala_sesion">Sala</label>
                <select name="sala_sesion" id="sala_sesion" onchange="mostrar_fechas()">
                    @foreach ($todas_salas as $sala)
                        <option value="{{ $sala->id }}" <?php if(isset($sesion_modificar)){
                            if($sesion_modificar->sala_id==$sala->id) {
                                echo "selected";
                            }
                        }?>>{{ $sala->codigo_sala }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="titulo">Fecha</label>
                <input type="date" class="form-control" id="fecha_sesion" name="fecha_sesion"
                       placeholder="Seleccione una fecha"
                       value="<?php if(isset($sesion_modificar)){
                           $anoMesDia=new DateTime($sesion_modificar->fecha);
                           echo $anoMesDia->format("Y-m-d");
                       }?>" onchange="mostrar_fechas()">
            </div>

            <div id="error_fecha_sesion" class="alert alert-danger" style="display: none"></div>
            <div id="error_dia_pasado" class="alert alert-danger" style="display: none"></div>

            <div class="form-group">
                <label for="titulo">Hora</label>
                <input type="time" class="form-control" id="hora_sesion" name="hora_sesion"
                       placeholder="Seleccione una hora"
                       value="<?php if(isset($sesion_modificar)){
                           $anoMesDia=new DateTime($sesion_modificar->fecha);
                           echo $anoMesDia->format("H:i");
                       }?>">
            </div>

            <div id="error_hora_sesion" class="alert alert-danger" style="display: none"></div>
            <div id="horas_ya_ocupadas"></div>

            <button id="button_submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
@extends('layouts.app')

@section('css_adicional')
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .asiento {
            width: 23px;
            padding: 2px;
        }

        #envio_asientos {
            margin-top: 20px;
        }

    </style>
@endsection

@section('js_adicional')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        function registro_asiento(elemento) {
            if(elemento.src.includes('silla_verde')) {
                elemento.src="{{url('/images/silla_azul.png')}}";
                document.getElementById('asientos_seleccionados').value+=elemento.id + " ";
            } else {
                elemento.src="{{url('/images/silla_verde.png')}}";
                let value_input = document.getElementById('asientos_seleccionados').value;
                document.getElementById('asientos_seleccionados').value = value_input.replace(elemento.id + " ","");
            }
        }

        $(document).ready(function() {
            $('#envio_asientos').submit(function(e) {
                $.ajax({
                    type: 'POST',
                    url:'comprobacion_vacio',
                    data: $(this).serialize(),
                    success: function(data) {

                        document.getElementById("error_asientos_vacios").style.display = "none";

                        if(data.error_asientos_vacios) {
                            document.getElementById("error_asientos_vacios").style.display = "block";
                            document.getElementById("error_asientos_vacios").innerHTML = data.error_asientos_vacios;
                            return false;
                        }

                        $("#envio_asientos")[0].submit();
                    }
                })
                e.preventDefault();
            });
            pintar_asientos_yaEscogidos();
        });

        function pintar_asientos_yaEscogidos() {
            <?php
            if(isset($asientos_seleccionados_vuelta)) {
            foreach (json_decode($asientos_seleccionados_vuelta) as $asiento_seleccionado) {
            ?>
            document.getElementById("<?= $asiento_seleccionado ?>").src="{{url('/images/silla_azul.png')}}";
            document.getElementById('asientos_seleccionados').value+=document.getElementById("<?= $asiento_seleccionado ?>").id + " ";
            <?php
            }
            }
            ?>
        }
    </script>
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
                        <div class="espacio_asientos">
                        <?php
                        use App\Pelicula_Sala;
                        $sesion_seleccionada = Pelicula_Sala::find($id_sesion);
                        $listado_asientos = $sesion_seleccionada->asientos;
                        $listado_asientos_objeto = json_decode($listado_asientos, true);
                        $asiento_pasillo = round($listado_asientos_objeto[sizeof($listado_asientos_objeto)-1]["butaca"]/2);
                        $total_fila = $listado_asientos_objeto[sizeof($listado_asientos_objeto)-1]["fila"];
                        $fila_pasillo = round($listado_asientos_objeto[sizeof($listado_asientos_objeto)-1]["fila"]*0.45);

                        for( $i = 0; $i<sizeof($listado_asientos_objeto); $i++ ) {
                        if ($i == 0) {
                            /*echo "<div>";
                            echo "asiento_pasillo" . $asiento_pasillo;
                            echo "total_fila" . $total_fila;
                            echo "fila_pasillo" . $fila_pasillo;
                            echo "</div>";*/
                        ?>
                        <div style="float:left">
                            <img src=@if($listado_asientos_objeto[$i]["email_cliente"]==null) {{url('/images/silla_verde.png')}}
                            @else {{url('/images/silla_roja.png')}}
                            @endif
                             alt="asiento" class="asiento"
                             id="{{$listado_asientos_objeto[$i]["fila"].'-'.$listado_asientos_objeto[$i]["butaca"]}}"
                             onclick="<?php
                             if ($listado_asientos_objeto[$i]["email_cliente"]==null) {
                                 echo 'registro_asiento(this)';
                             }
                             ?>"
                             data-toggle="tooltip" data-placement="top"
                             title="{{'Fila: '.$listado_asientos_objeto[$i]["fila"].' / Columna: '.$listado_asientos_objeto[$i]["butaca"]}}"
                            />
                        </div>
                        <?php
                        } else {
                        if ($listado_asientos_objeto[$i]["fila"]==$listado_asientos_objeto[$i-1]["fila"]) {
                        ?>
                        <div style="float:left;
                            <?php
                                //Generacion de los pasillos
                                $sentencia="";
                                if($total_fila>=16) {
                                    if($asiento_pasillo==$listado_asientos_objeto[$i]["butaca"] &&
                                        $fila_pasillo==$listado_asientos_objeto[$i]["fila"]) {
                                        $sentencia.='margin-right: 25px; margin-bottom: 25px';
                                    } elseif ($asiento_pasillo==$listado_asientos_objeto[$i]["butaca"]) {
                                        $sentencia.='margin-right: 25px';
                                    }
                                } else {
                                    if($asiento_pasillo==$listado_asientos_objeto[$i]["butaca"]) {
                                        $sentencia.='margin-right: 25px';
                                    }
                                }
                                echo $sentencia;
                            ?>
                        ">
                            <img src=@if($listado_asientos_objeto[$i]["email_cliente"]==null) {{url('/images/silla_verde.png')}}
                            @else {{url('/images/silla_roja.png')}}
                            @endif
                                 alt="asiento" class="asiento"
                                 id="{{$listado_asientos_objeto[$i]["fila"].'-'.$listado_asientos_objeto[$i]["butaca"]}}"
                                 onclick="<?php
                                 if ($listado_asientos_objeto[$i]["email_cliente"]==null) {
                                     echo 'registro_asiento(this)';
                                 }
                                 ?>"
                                 data-toggle="tooltip" data-placement="top"
                                 title="{{'Fila: '.$listado_asientos_objeto[$i]["fila"].' / Asiento: '.$listado_asientos_objeto[$i]["butaca"]}}"
                            />
                        </div>
                        <?php
                        } else {
                        ?>
                        <div style="clear: both"></div>
                            <div style="float:left;">
                            <img src=@if($listado_asientos_objeto[$i]["email_cliente"]==null) {{url('/images/silla_verde.png')}}
                            @else {{url('/images/silla_roja.png')}}
                            @endif
                                    alt="asiento" class="asiento"
                                 id="{{$listado_asientos_objeto[$i]["fila"].'-'.$listado_asientos_objeto[$i]["butaca"]}}"
                                 onclick="<?php
                                 if ($listado_asientos_objeto[$i]["email_cliente"]==null) {
                                     echo 'registro_asiento(this)';
                                 }
                                 ?>"
                                 data-toggle="tooltip" data-placement="top"
                                 title="{{'Fila: '.$listado_asientos_objeto[$i]["fila"].' / Columna: '.$listado_asientos_objeto[$i]["butaca"]}}"
                            />
                        </div>
                        <?php
                        }
                        }
                        }
                        ?>
                        <div style="clear: both"></div>
                        </div><!-- espacio asientos -->
                        <form id="envio_asientos" method="POST" action="{{ route('seleccion_asientos02') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="asientos_seleccionados" name="asientos_seleccionados" value="">
                            <input type="hidden" id="id_sesion" name="id_sesion" value="{{$id_sesion}}">
                            <div style="display: none; color: darkred" id="error_asientos_vacios"></div>
                            <button type="submit" class="btn btn-primary">Reservar asientos</button>
                        </form>
                    </div>
                </div>
            </div> <!-- .container -->
        </main>
        @include('footer_cine');
    </div>
@endsection
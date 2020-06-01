@extends('layouts.app')

@section('css_adicional')
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

        .area_botones {
            margin-top: 40px;
            margin-bottom: 20px;
        }

        .factura_entradas {
            margin-bottom: 14px;
        }

        .factura_entradas span{
            color: #404040;
        }

        .area_encabezado {
            width: 80%;
            padding-left: 3px;
        }

        .area_encabezado hr {
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .primer_bloque_row {
            margin-bottom: 30px;
        }

        #area_factura {
            margin-top: -7px;
        }

    </style>
@endsection

@section('js_adicional')
    <script>
        function despliegue_capas(elemento) {
            let capa_comida = document.getElementById("capa_comida");
            let capa_bebida = document.getElementById("capa_bebida");

            if(elemento.id=="boton_comida") {

                if (capa_comida.style.display=="none") {
                    capa_bebida.style.display="none";
                    capa_comida.style.display="block";
                } else {
                    capa_comida.style.display="none";
                }
            } else {

                if (capa_bebida.style.display=="none") {
                    capa_bebida.style.display="block";
                    capa_comida.style.display="none";
                } else {
                    capa_bebida.style.display="none";
                }
            }
        }

        $(document).ready(function() {
            $('#formulario_sesiones').submit(function(e) {
                $.ajax({
                    type: 'POST',
                    url:'comprobacion_email',
                    data: $(this).serialize(),
                    success: function(data) {

                        document.getElementById("error_email_vacio").style.display = "none";

                        if(data.error_email_vacio) {
                            document.getElementById("error_email_vacio").style.display = "block";
                            document.getElementById("error_email_vacio").innerHTML = data.error_email_vacio;
                            return false;
                        } else {
                            var r = confirm("¿Está seguro de esta compra?");
                            if (r == true) {
                                $("#formulario_sesiones")[0].submit();
                            } else {
                            }
                        }
                        //$("#formulario_sesiones")[0].submit();
                    }
                });
                e.preventDefault();
            });
            mostrar_factura();
        });

        function mostrar_factura() {
            document.getElementById("area_factura").innerHTML = "";
            let total = 0;
            let array_precio_entradas = null;
            let precio_entrada = 0;
            let precio_comida = 0;
            let total_comida = 0;
            let precio_bebida = 0;
            let total_bebida = 0;

            document.getElementById("area_factura").innerHTML += "<div class='area_encabezado'>FACTURA<hr></div>";
            <?php
                foreach ($asientos_seleccionados_array as $asiento_seleccionado) {
                    $asiento_individual_array = explode("-", $asiento_seleccionado);
                    $fila=$asiento_individual_array[0];
                    $asiento=$asiento_individual_array[1];
            ?>
                document.getElementById("area_factura").innerHTML += "<div class='factura_entradas'><span>- &nbspFila {{$fila}} / Asiento {{$asiento}}: &nbsp</span>"
                + document.getElementById("<?= $asiento_seleccionado ?>").value + "€</div>";

                array_precio_entradas = document.getElementById("<?= $asiento_seleccionado ?>").value.split(" ");
                precio_entrada = parseFloat(array_precio_entradas[array_precio_entradas.length-1]);
                total += precio_entrada;

            <?php
                }

                foreach ($todas_comida as $comida) {
            ?>
                if (document.getElementById("<?= $comida->nombre ?>").value!=0) {
                total_comida = 0;
                document.getElementById("area_factura").innerHTML += "<div class='factura_entradas'><span>- &nbsp<?= $comida->nombre.' ('.$comida->precio.' €)' ?></span> &nbspx &nbsp" + document.getElementById("<?= $comida->nombre ?>").value + "</div>";

                precio_comida = <?= $comida->precio ?>;
                total_comida += precio_comida * document.getElementById("<?= $comida->nombre ?>").value;
                total += total_comida;
                console.log("Comida: " + precio_comida);
                console.log("totalComida: " + total_comida);

                }
            <?php
                }

                foreach ($todas_bebida as $bebida) {
            ?>
                if (document.getElementById("<?= $bebida->nombre ?>").value!=0) {
                total_bebida = 0;
                document.getElementById("area_factura").innerHTML += "<div class='factura_entradas'><span>- &nbsp<?= $bebida->nombre.' ('.$bebida->precio.' €)' ?></span> &nbspx &nbsp" + document.getElementById("<?=$bebida->nombre ?>").value + "</div>";

                precio_bebida = <?= $bebida->precio ?>;
                total_bebida += precio_bebida * document.getElementById("<?= $bebida->nombre ?>").value;
                total += total_bebida;
                console.log("Bebida: " + precio_bebida);
                console.log("Bebida: " + precio_bebida);
                console.log("totalBebida: " + total_bebida);

                }
            <?php
                }
            ?>
            document.getElementById("area_factura").innerHTML += " &nbspTOTAL: " + total + "€";
            document.getElementById("total").value = total;
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
                        <form id="formulario_sesiones" method="post" action="{{ route('seleccion_asientos03') }}">
                            <div class="row">
                                <div class="col-sm-6">
                                     @csrf
                                     <input type="hidden" name="asientos_seleccionados" value="{{json_encode($asientos_seleccionados_array)}}">
                                     <input type="hidden" id="id_sesion" name="id_sesion" value="{{$id_sesion}}">
                                     <input type="hidden" id="total" name="total" value="">

                                    @foreach ($asientos_seleccionados_array as $asiento_seleccionado)
                                         @php
                                             $asiento_individual_array = explode("-", $asiento_seleccionado);
                                             $fila=$asiento_individual_array[0];
                                             $asiento=$asiento_individual_array[1];
                                         @endphp
                                         <div class="form-group">
                                             <label style="margin-right: 10px;" for="{{ $asiento_seleccionado }}">Fila {{$fila}} / Asiento {{$asiento}}: </label>
                                             <select id="{{ $asiento_seleccionado }}" name="{{ $asiento_seleccionado }}" onchange="mostrar_factura()">
                                                 @foreach ($todas_entradas as $entrada)
                                                     <option value="{{ $entrada->nombre }} {{ $entrada->precio }}">{{ $entrada->nombre }}: {{ $entrada->precio }}€</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     @endforeach
                                </div><!-- Finaliza primer col-sm-6-->
                                <div id="area_factura" class="col-sm-6"></div><!-- area  col-sm-6 para la factura-->

                                <div class="area_botones col-sm-12">
                                     <a style="color: black !important;" id="boton_comida" class="btn btn-info" onclick="despliegue_capas(this)">Comida</a>
                                     <a style="color: black !important;" id="boton_bebida" class="btn btn-info" onclick="despliegue_capas(this)">Bebida</a>
                                </div>

                                 <div id="capa_comida" style="display: none; padding-left: 0px; margin-bottom: 25px" class="col-sm-12">
                                     @foreach ($todas_comida as $comida)
                                         <div class="col-sm-4">
                                             <!--<img style="float: left; width: 140px;" src="{{ asset($comida->foto) }}">-->
                                             <img src="{{url(str_replace("images", "productCropImages", $comida->foto))}}" alt="Slide">
                                             <div class="form-group">
                                                 <label for="{{ $comida->nombre }}">{{ str_replace("_"," ",$comida->nombre) . " -> " . $comida->precio . " €"}}</label>
                                                 <input type="number" class="form-control" id="{{ $comida->nombre }}" name="{{ $comida->nombre }}"
                                                        value="0" onchange="mostrar_factura()" min="0">
                                             </div>
                                         </div>
                                     @endforeach
                                 </div>

                                 <div id="capa_bebida" style="display: none; padding-left: 0px; margin-bottom: 25px" class="col-sm-12">
                                     @foreach ($todas_bebida as $bebida)
                                         <div class="col-sm-4">
                                             <!--<img style="float: left; width: 140px;" src="{{ asset($bebida->foto) }}">-->
                                             <img src="{{url(str_replace("images", "productCropImages", $bebida->foto))}}" alt="Slide">
                                             <div class="form-group">
                                                 <label for="{{ $bebida->nombre }}">{{ str_replace("_"," ",$bebida->nombre) . " -> " . $bebida->precio . " €"}}</label>
                                                 <input type="number" class="form-control" id="{{ $bebida->nombre }}" name="{{ $bebida->nombre }}"
                                                        value="0" onchange="mostrar_factura()" min="0">
                                             </div>
                                         </div>
                                     @endforeach
                                 </div>

                                 <div class="col-sm-6 form-group">
                                     <label style="color: darkred;" for="email"><b>Email: </b></label>
                                     <input type="email" class="form-control" id="email" name="email"
                                            value="">
                                     <div style="display: none; color: darkred" id="error_email_vacio"></div>
                                 </div>

                                <div class="col-sm-12">
                                 <button type="submit" class="btn btn-primary">Continuar</button>
                                </div>
                            </div>
                        </form>

                        <div class="col-sm-12" style="margin-top: 15px; padding-left: 0px">
                            <form id="volver_atras_butacas01" method="post" action="{{ route('seleccion_asientos01') }}">
                                @csrf
                                <input type="hidden" name="asientos_seleccionados_vuelta" value="{{json_encode($asientos_seleccionados_array)}}">
                                <input type="hidden" name="id_sesion" value="{{$id_sesion}}">
                                <button type="submit" class="btn btn-primary">Vuelta atrás</button>
                            </form>
                        </div>

                    </div> <!-- content -->
                </div><!-- page -->
            </div><!-- container -->
        </main>
        @include('footer_cine');
    </div>
@endsection
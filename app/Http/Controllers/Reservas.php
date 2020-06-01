<?php

namespace App\Http\Controllers;
use App\Mail\CinemaMail;
use App\Pelicula_Sala;
use App\Producto;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Reservas extends Controller
{
    public function seleccion_asientos01(Request $request) {
        $id_sesion = $request->id_sesion;

        if(isset($request->asientos_seleccionados_vuelta)) {
            return view('seleccion_asientos01', ["id_sesion"=>$id_sesion, "asientos_seleccionados_vuelta"=>$request->asientos_seleccionados_vuelta]);
        } else {
            return view('seleccion_asientos01', ["id_sesion"=>$id_sesion]);
        }
    }

    public function seleccion_asientos02(Request $request) {
        $id_sesion = $request->id_sesion;
        $asientos_seleccionados = $request->asientos_seleccionados;
        $asientos_seleccionados_array = explode(" ", $asientos_seleccionados);

        $todas_entradas = Producto::where('categoria', 'entradas')
            ->orderBy('nombre', 'asc')
            ->get();

        $todas_comida = Producto::where('categoria', 'comida')
            ->orderBy('nombre', 'asc')
            ->get();

        $todas_bebida = Producto::where('categoria', 'bebida')
            ->orderBy('nombre', 'asc')
            ->get();

        return view('seleccion_asientos02', ["asientos_seleccionados_array" => $asientos_seleccionados_array,
            "todas_entradas" => $todas_entradas,
            "todas_comida" => $todas_comida,
            "todas_bebida" => $todas_bebida,
            "id_sesion" => $id_sesion,
        ]);
    }

    public function comprobacion_vacio(Request $request) {

        $asientos = $request->asientos_seleccionados;

        if ($asientos == "") {
            $error_asientos_vacios = "No ha seleccionado ningún asiento";
            return response()->json(array('error_asientos_vacios'=> $error_asientos_vacios), 200);
        }

        return response()->json(array('exito'=> ''), 200);
    }

    public function comprobacion_email(Request $request) {

        $email = $request->email;

        if ($email=="") {
            $error_email_vacio = "No ha introducido ningún email";
            return response()->json(array('error_email_vacio'=> $error_email_vacio), 200);
        }

        return response()->json(array('exito'=> ''), 200);
    }

    public function seleccion_asientos03(Request $request) {

        date_default_timezone_set('Europe/Madrid');

        $todas_entradas = Producto::where('categoria', 'entradas')
            ->orderBy('nombre', 'asc')
            ->get();

        $todas_comida = Producto::where('categoria', 'comida')
            ->orderBy('nombre', 'asc')
            ->get();

        $todas_bebida = Producto::where('categoria', 'bebida')
            ->orderBy('nombre', 'asc')
            ->get();

        $id_sesion = $request->id_sesion;
        $email = $request->email;
        $total = $request->total;
        $fecha_compra = date('d/m/Y h:i:s a', time());
        $asientos_seleccionados = json_decode($request->asientos_seleccionados);
        $sesion_objeto = Pelicula_Sala::find($id_sesion);
        $listado_asientos_sala = json_decode($sesion_objeto->asientos);
        $array_ticket = array();

        foreach ($asientos_seleccionados as $asiento_seleccionado) {
            $asiento_individual_array = explode("-", $asiento_seleccionado);
            $fila = $asiento_individual_array[0];
            $butaca = $asiento_individual_array[1];
            foreach ($listado_asientos_sala as $asiento_objeto) {
                if ($asiento_objeto->fila==$fila && $asiento_objeto->butaca==$butaca && $asiento_objeto->email_cliente==null) {
                    $asiento_objeto->email_cliente = $email;
                    $asiento_objeto->fecha_compra = $fecha_compra;
                    $asiento_objeto->tipo_entrada = $request->$asiento_seleccionado;
                    $array_productos = array();

                    foreach ($todas_comida as $comida) {
                        $nombre_comida = $comida->nombre;
                        $precio_comida = $comida->precio;
                        if($request->$nombre_comida>0) {
                            $array_productos[$nombre_comida . "/" . $precio_comida] = $request->$nombre_comida;
                        }
                    }

                    foreach ($todas_bebida as $bebida) {
                        $nombre_bebida = $bebida->nombre;
                        $precio_bebida = $bebida->precio;
                        if($request->$nombre_bebida>0) {
                            $array_productos[$nombre_bebida . "/" . $precio_bebida] = $request->$nombre_bebida;
                        }
                    }

                    $asiento_objeto->productos = $array_productos;
                    array_push($array_ticket,$asiento_objeto);
                    //$array_ticket[] = $asiento_objeto;
                }
            }
        }

        $sesion_objeto->asientos = json_encode($listado_asientos_sala);
        $sesion_objeto->save();

        $datos_sesion = Pelicula_Sala::select('peliculas.titulo', 'salas.codigo_sala', 'pelicula_sala.fecha', 'peliculas.duracion')
            ->join('salas', 'pelicula_sala.sala_id', '=', 'salas.id')
            ->join('peliculas', 'pelicula_sala.pelicula_id', '=', 'peliculas.id')
            ->where('pelicula_sala.id', $id_sesion)
            ->get();

        /*echo gettype($datos_sesion);
        echo json_encode($datos_sesion);
        echo gettype($array_ticket);
        echo json_encode($array_ticket);*/

        Mail::to($email)->send(new CinemaMail($array_ticket, $datos_sesion[0]));
        //return new CinemaMail($array_ticket, $datos_sesion[0]);
        return view('seleccion_asientos03', ["email" => $email]);
    }
}

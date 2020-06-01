<?php

namespace App\Http\Controllers;

use App\Pelicula;
use App\Pelicula_Sala;
use App\Sala;
use Carbon\Carbon;
use Session;
use DateTime;
use DateInterval;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SesionesAdministracion extends Controller
{
    public function mostrar_todas_sesiones() {

        $todas_sesiones = Pelicula_Sala::select('pelicula_sala.pelicula_id', 'pelicula_sala.sala_id',
            'peliculas.titulo', 'salas.codigo_sala', 'pelicula_sala.fecha', 'peliculas.duracion',
            'pelicula_sala.created_at', 'pelicula_sala.updated_at', 'pelicula_sala.id')
            ->join('salas', 'pelicula_sala.sala_id', '=', 'salas.id')
            ->join('peliculas', 'pelicula_sala.pelicula_id', '=', 'peliculas.id')
            ->where('pelicula_sala.fecha', '>=', Carbon::now('Europe/Paris'))
            ->orderBy('pelicula_sala.fecha', 'asc')
            ->paginate(10);

        return view('admin_sesiones', ['todas_sesiones' => $todas_sesiones]);
    }

    public function redireccion_formulario_sesion(Request $request) {
        $todas_peliculas = Pelicula::select('id','titulo')->where('en_cartelera', true)->get();
        $todas_salas = Sala::select('id','codigo_sala')->get();
        if ($request->id=="0") {
            return view('formulario_sesiones', ['todas_peliculas' => $todas_peliculas, 'todas_salas' => $todas_salas]);
        } else {
            return view('formulario_sesiones', ['sesion_modificar' => Pelicula_Sala::findOrFail($request->id),
                'todas_peliculas' => $todas_peliculas, 'todas_salas' => $todas_salas]);
        }
    }

    public function comprobacion_fecha(Request $request) {
        $id = $request->id;
        //$pelicula = $request->pelicula;
        $sala = $request->sala;
        $fecha = $request->fecha;
        $sesiones_existentes = null;

        if ($id==0) {
            $sesiones_existentes = Pelicula_Sala::select('peliculas.titulo', 'salas.codigo_sala', 'pelicula_sala.fecha', 'peliculas.duracion')
                ->join('salas', 'pelicula_sala.sala_id', '=', 'salas.id')
                ->join('peliculas', 'pelicula_sala.pelicula_id', '=', 'peliculas.id')
                //->where('pelicula_sala.pelicula_id', $pelicula)
                ->where('pelicula_sala.sala_id', $sala)
                ->whereDate('pelicula_sala.fecha', $fecha)
                ->orderBy('pelicula_sala.fecha', 'ASC')
                ->get();
        } else {
            $sesiones_existentes = Pelicula_Sala::select('peliculas.titulo', 'salas.codigo_sala', 'pelicula_sala.fecha', 'peliculas.duracion')
                ->join('salas', 'pelicula_sala.sala_id', '=', 'salas.id')
                ->join('peliculas', 'pelicula_sala.pelicula_id', '=', 'peliculas.id')
                ->where('pelicula_sala.id', '!=' , $id)
                //->where('pelicula_sala.pelicula_id', $pelicula)
                ->where('pelicula_sala.sala_id', $sala)
                ->whereDate('pelicula_sala.fecha', $fecha)
                ->orderBy('pelicula_sala.fecha', 'ASC')
                ->get();
        }

        return response()->json(array('sesiones_existentes'=> $sesiones_existentes, 'id'=> $id), 200);
    }

    public function comprobaciones_preSubmit(Request $request) {
        date_default_timezone_set("Europe/Madrid");
        $duracion_pelicula = Pelicula::select('duracion')->where('id', $request->pelicula_sesion)->first()["duracion"];
        $id = $request->id;
        $pelicula_sesion = $request->pelicula_sesion;
        $sala_sesion = $request->sala_sesion;
        $fecha_sesion = $request->fecha_sesion;
        $hora_sesion = $request->hora_sesion;

        if($fecha_sesion=="") {
            $error_fecha_sesion = "Introduzca una fecha";
            return response()->json(array('error_fecha_sesion'=> $error_fecha_sesion), 200);
        }

        if($hora_sesion=="") {
            $error_hora_sesion = "Introduzca una hora";
            return response()->json(array('error_hora_sesion'=> $error_hora_sesion), 200);
        }

        if ($request->fecha_sesion < date("Y-m-d")) {
            $error_fecha_sesion = "No es posible seleccionar un día que ya ha pasado";
            return response()->json(array('error_fecha_sesion' => $error_fecha_sesion), 200);
        }

        if ($request->fecha_sesion == date("Y-m-d")) {
          if ($request->hora_sesion <= date("H:i")) {
                $error_hora_sesion = "Imposible introducir la hora actual o una hora que ha pasado";
                return response()->json(array('error_hora_sesion'=> $error_hora_sesion), 200);
            } else {
              $ocupado = false;
              $date_escogida_inicio = new DateTime($request->fecha_sesion . " " . $request->hora_sesion);
              $manana_date = new DateTime($request->fecha_sesion . " " . $request->hora_sesion);
              $manana_date->modify('+1 day');
              $ayer_date = new DateTime($request->fecha_sesion . " " . $request->hora_sesion);
              $ayer_date->modify('-1 day');

              $horas_ayerHoyManana = null;

              if ($request->id == "0") {
                  $horas_ayerHoyManana = Pelicula_Sala::select('fecha')
                      ->where('sala_id', $request->sala_sesion)
                      ->whereBetween('fecha', [$ayer_date->format('Y-m-d'), $manana_date->format('Y-m-d')])
                      ->get();
              } else {
                  $horas_ayerHoyManana = Pelicula_Sala::select('fecha')
                      ->where('sala_id', $request->sala_sesion)
                      ->whereBetween('fecha', [$ayer_date->format('Y-m-d'), $manana_date->format('Y-m-d')])
                      ->where('id', '!=' , $request->id)->get();
              }

              //Controlar que verdaderamente hay horas en ese día
              foreach ($horas_ayerHoyManana as $fecha_inicio) {
                  $fecha_inicio_date = new DateTime($fecha_inicio["fecha"]);
                  $fecha_final_date = new DateTime($fecha_inicio["fecha"]);
                  $fecha_final_date->add(new DateInterval('PT' . $duracion_pelicula . 'M'));

                  $date_escogida_final = new DateTime($request->fecha_sesion . " " . $request->hora_sesion);
                  $date_escogida_final->add(new DateInterval('PT' . $duracion_pelicula . 'M'));

                  if ($date_escogida_inicio >= $fecha_inicio_date && $date_escogida_inicio <= $fecha_final_date) {
                      $ocupado = true;
                      break;
                  }
                  if ($date_escogida_final >= $fecha_inicio_date && $date_escogida_final <= $fecha_final_date) {
                      $ocupado = true;
                      break;
                  }
              }

              if ($ocupado == true) {
                  $error_hora_sesion = "La hora pertenece ya a otra sesión";
                  return response()->json(array('error_hora_sesion'=> $error_hora_sesion), 200);
              }
            }
        }

        if ($request->fecha_sesion > date("Y-m-d")) {

            $ocupado = false;
            $date_escogida_inicio = new DateTime($request->fecha_sesion . " " . $request->hora_sesion);
            $manana_date = new DateTime($request->fecha_sesion . " " . $request->hora_sesion);
            $manana_date->modify('+1 day');
            $ayer_date = new DateTime($request->fecha_sesion . " " . $request->hora_sesion);
            $ayer_date->modify('-1 day');

            $horas_ayerHoyManana = null;

            if ($request->id == "0") {
                $horas_ayerHoyManana = Pelicula_Sala::select('fecha')
                    ->where('sala_id', $request->sala_sesion)
                    ->whereBetween('fecha', [$ayer_date->format('Y-m-d'), $manana_date->format('Y-m-d')])
                    ->get();
            } else {
                $horas_ayerHoyManana = Pelicula_Sala::select('fecha')
                    ->where('sala_id', $request->sala_sesion)
                    ->whereBetween('fecha', [$ayer_date->format('Y-m-d'), $manana_date->format('Y-m-d')])
                    ->where('id', '!=' , $request->id)->get();
            }

            //Controlar que verdaderamente hay horas en ese día
            foreach ($horas_ayerHoyManana as $fecha_inicio) {
                $fecha_inicio_date = new DateTime($fecha_inicio["fecha"]);
                $fecha_final_date = new DateTime($fecha_inicio["fecha"]);
                $fecha_final_date->add(new DateInterval('PT' . $duracion_pelicula . 'M'));

                $date_escogida_final = new DateTime($request->fecha_sesion . " " . $request->hora_sesion);
                $date_escogida_final->add(new DateInterval('PT' . $duracion_pelicula . 'M'));

                if ($date_escogida_inicio >= $fecha_inicio_date && $date_escogida_inicio <= $fecha_final_date) {
                    $ocupado = true;
                    break;
                }
                if ($date_escogida_final >= $fecha_inicio_date && $date_escogida_final <= $fecha_final_date) {
                    $ocupado = true;
                    break;
                }
            }

            if ($ocupado == true) {
                $error_hora_sesion = "La hora pertenece ya a otra sesión";
                return response()->json(array('error_hora_sesion'=> $error_hora_sesion), 200);
            }
        }

        return response()->json(array('exito'=> ''), 200);
    }

    public function anadir_modificar_sesion(Request $request)
    {
        date_default_timezone_set("Europe/Madrid");
        $date_escogida_inicio = new DateTime($request->fecha_sesion . " " . $request->hora_sesion);

        if ($request->id == "0") {

                $sesion_insertar = new Pelicula_Sala();
                $sesion_insertar->pelicula_id = $request->pelicula_sesion;
                $sesion_insertar->sala_id = $request->sala_sesion;
                $sesion_insertar->fecha = $date_escogida_inicio->format('Y-m-d H:i:s');
                $ancho_largo = Sala::select('largo', 'ancho')->where('id', $request->sala_sesion)->first();
                $ancho = $ancho_largo["ancho"];
                $largo = $ancho_largo["largo"];
                $asiento_string = '[';
                for ($i = 1; $i <= $largo; $i++) {
                    for ($j = 1; $j <= $ancho; $j++) {
                        if ($i == $largo && $j == $ancho) {
                            $asiento_string .= '{"fila":' . $i . ', "butaca":' . $j . ', "email_cliente":null, "fecha_compra":null, "tipo_entrada":null, "productos":null}]';
                        } else {
                            $asiento_string .= '{"fila":' . $i . ', "butaca":' . $j . ', "email_cliente":null, "fecha_compra":null, "tipo_entrada":null, "productos":null},';
                        }
                    }
                }
                $sesion_insertar->asientos = $asiento_string;
                $sesion_insertar->save();
                $id_insertado = $sesion_insertar->id;

            return redirect()->route('admin_sesiones')->with('sesion_insertada', array($request->pelicula_sesion,
                $request->sala_sesion, $date_escogida_inicio->format('Y-m-d H:i:s'), $id_insertado));

        } else {
            $sesion_insertar = Pelicula_Sala::find($request->id);
            $sesion_insertar->pelicula_id = $request->pelicula_sesion;
            $sesion_insertar->sala_id = $request->sala_sesion;
            $sesion_insertar->fecha = $date_escogida_inicio->format('Y-m-d H:i:s');

            //COMPROBAR QUE SI YA HAY USUARIOS EN LA SALA NO SE PUEDE MODIFICAR

            $ancho_largo = Sala::select('largo', 'ancho')->where('id', $request->sala_sesion)->first();
            $ancho = $ancho_largo["ancho"];
            $largo = $ancho_largo["largo"];
            $asiento_string = '[';
            for ($i = 1; $i <= $largo; $i++) {
                for ($j = 1; $j <= $ancho; $j++) {
                    if ($i == $largo && $j == $ancho) {
                        $asiento_string .= '{"fila":' . $i . ', "butaca":' . $j . ', "email_cliente":null, "fecha_compra":null, "tipo_entrada":null, "productos":null}]';
                    } else {
                        $asiento_string .= '{"fila":' . $i . ', "butaca":' . $j . ', "email_cliente":null, "fecha_compra":null, "tipo_entrada":null, "productos":null},';
                    }
                }
            }
            $sesion_insertar->asientos = $asiento_string;
            $sesion_insertar->save();
            return redirect()->route('admin_sesiones');
        }
    }
}
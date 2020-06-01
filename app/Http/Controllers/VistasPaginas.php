<?php

namespace App\Http\Controllers;

use App\Pelicula;
use App\Pelicula_Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VistasPaginas extends Controller
{

    public function redireccion_portada() {

        $ultimas_tres_peliculas = Pelicula::where('en_cartelera', true)->orderBy('id', 'desc')->take(3)->get();

        $dos_peliculas =  Pelicula::where('en_cartelera', true)->orderBy('id', 'desc')->skip(3)->take(2)->get();

        $cuatro_peliculas =  Pelicula::where('en_cartelera', true)->orderBy('id', 'desc')->skip(5)->take(4)->get();


        //return ($ultimas_tres_peliculas[2]);

        return view('home', ["ultimas_tres_peliculas"=>$ultimas_tres_peliculas, "dos_peliculas"=>$dos_peliculas, "cuatro_peliculas"=>$cuatro_peliculas]);

    }

    public function redireccion_about() {

        return view('about');

    }

    public function redireccion_single($id, Request $request) {
        //Seleccionamos los cinco proximos dias en los que se emite una determinada pelicula

        /*$seleccion_cinco_dias = DB::select('SELECT DATE(fecha) AS fecha_seleccionada FROM pelicula_sala WHERE pelicula_id = ?
        AND DATE(fecha) >= CURRENT_DATE GROUP BY DATE(fecha) ORDER BY DATE(fecha) ASC LIMIT 5', [$id]);*/

        $seleccion_cinco_dias = DB::select('SELECT DATE(fecha) AS fecha_seleccionada FROM pelicula_sala WHERE pelicula_id = ?
        AND fecha > CURRENT_TIMESTAMP() GROUP BY DATE(fecha) ORDER BY DATE(fecha) ASC LIMIT 5', [$id]);

        //Seleccionamos las horas existentes en esos dias

        $seleccion_horas_completas = array();

        if(sizeof($seleccion_cinco_dias)!=0){
            $date_baja = $seleccion_cinco_dias[0]->fecha_seleccionada;
            $date_alta = $seleccion_cinco_dias[sizeof($seleccion_cinco_dias)-1]->fecha_seleccionada;

            $seleccion_horas_completas = DB::select('SELECT ps.id AS id, sa.codigo_sala AS sala, ps.fecha AS fecha, pe.duracion AS duracion FROM pelicula_sala ps INNER JOIN
peliculas pe ON pe.id = ps.pelicula_id INNER JOIN salas sa ON sa.id = ps.sala_id WHERE pe.id = ? AND ps.fecha > CURRENT_TIMESTAMP() AND DATE(ps.fecha) 
BETWEEN ? AND ? ORDER BY DATE(ps.fecha)', [$id, $date_baja, $date_alta]);
        }

        return view('single', ['pelicula' => Pelicula::findOrFail($id), 'sesiones_5dias' => $seleccion_horas_completas]);
    }

    public function redireccion_reviewGeneral() {

        $todas_peliculas=Pelicula::where('en_cartelera', 1)->orderBy('id', 'desc') ->paginate(8);

        //$anos_peliculas = DB::select('SELECT YEAR(estreno) as ano FROM peliculas WHERE en_cartelera=1 GROUP BY YEAR(estreno) ORDER BY YEAR(estreno) DESC');
        //return json_encode($anos_peliculas);

        return view('review', ["todas_peliculas"=>$todas_peliculas]);
    }

    public function redireccion_reviewSeleccionada(Request $request) {

        $genero = $request->select_genero;


        $peliculas_genero = Pelicula::where('en_cartelera', 1)
            ->where('categorias', 'LIKE', '%'.$genero.'%')
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('review', ["peliculas_genero"=>$peliculas_genero, "genero_escogido"=>$genero]);
    }

    public function redireccion_contact() {

        return view('contact');

    }
}

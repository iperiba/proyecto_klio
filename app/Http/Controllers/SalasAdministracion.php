<?php

namespace App\Http\Controllers;

use App\Sala;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalasAdministracion extends Controller
{
    public function mostrar_todas_salas() {
        $todas_salas = Sala::paginate(10);
        return view('admin_salas', ['todas_salas' => $todas_salas]);
    }

    public function redireccion_formulario_sala($id = null) {
        if ($id==null) {
            return view('formulario_salas');
        } else {
            return view('formulario_salas', ['sala_modificar' => Sala::findOrFail($id)]);
        }
    }

    public function eliminar_sala($id) {
        $sala = Sala::find($id);
        $sala->delete();
        return redirect()->route('admin_salas');
    }

    public function anadir_modificar_sala(Request $request)
    {
        if ($request->id == "0") {
            $validator = Validator::make($request->all(), [
                'codigo_sala' => 'required|unique:salas,codigo_sala',
                'largo' => 'required',
                'ancho' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect(route("formulario_sala"))
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $sala = new Sala();
                $sala->codigo_sala = $request->codigo_sala;
                $sala->largo = $request->largo;
                $sala->ancho = $request->ancho;

                $sala->save();
                return redirect()->route('admin_salas');
            }
        } else {
            $validator = Validator::make($request->all(), [
                'codigo_sala' => 'required',
                'largo' => 'required',
                'ancho' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect(route("formulario_pelicula"))
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if (Sala::where('codigo_sala', [$request->codigo_sala])
                    ->whereNotIn('id', [$request->id])
                    ->exists()) {

                    Session::flash('message', "Ya existe una sala con ese código");
                    return back()->withInput();

                } else {
                    $sala = Sala::find($request->id);

                    $sala->codigo_sala = $request->codigo_sala;
                    $sala->largo = $request->largo;
                    $sala->ancho = $request->ancho;

                    $sala->save();
                    return redirect()->route('admin_salas');

                }
            }
        }
    }
}

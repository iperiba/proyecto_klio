<?php

namespace App\Http\Controllers;
use App\Pelicula;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeliculasAdministracion extends Controller
{
    public function mostrar_todas_peliculas() {

        $todas_peliculas = Pelicula::where('en_cartelera', 1)
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('admin_peliculas02', ['todas_peliculas' => $todas_peliculas]);
    }

    public function redireccion_formulario_pelicula($id = null) {
        if ($id==null) {
            return view('formulario_peliculas');
        } else {
            return view('formulario_peliculas', ['pelicula_modificar' => Pelicula::findOrFail($id)]);
        }
    }

    public function desactivar_pelicula($id) {
        $pelicula = Pelicula::find($id);
        $pelicula->en_cartelera = false;
        $pelicula->save();
        return redirect()->route('admin_peliculas');
    }

    public function anadir_modificar_pelicula(Request $request)
    {
        if ($request->id == "0") {
            $validator = Validator::make($request->all(), [
                'titulo' => 'required',
                'director' => 'required',
                'guionistas' => 'required',
                'actores' => 'required',
                'categorias' => 'required|array',
                'cartel' => 'required|image',
                'sinopsis' => 'required',
                'trailer' => 'required|file',
                'duracion' => 'required|numeric',
                'estreno' => 'required|date'
            ]);

            if ($validator->fails()) {
                return redirect(route("formulario_pelicula"))
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if (Pelicula::where('titulo', $request->titulo)
                    ->where('director', $request->director)
                    ->where('actores', $request->actores)
                    ->where('guionistas', $request->guionistas)
                    //->where('categorias', implode(', ', $request->categorias))
                    ->where('sinopsis', $request->sinopsis)
                    ->where('duracion', $request->duracion)
                    ->where('en_cartelera', true)
                    ->where('estreno', $request->estreno)
                    ->exists()) {

                    Session::flash('message', "La película ya existe en nuestros registros");
                    return back()->withInput();
                } else {
                    $pelicula = new Pelicula();
                    $pelicula->titulo = $request->titulo;
                    $pelicula->director = $request->director;
                    $pelicula->guionistas = $request->guionistas;
                    $pelicula->actores = $request->actores;
                    $pelicula->categorias = implode(', ', $request->categorias);
                    $pelicula->sinopsis = $request->sinopsis;
                    $pelicula->duracion = $request->duracion;
                    $pelicula->estreno = $request->estreno;

                    if ($request->hasFile('cartel')) {
                        if ($request->file('cartel')->isValid()) {
                            $nombre_cartel = $request->titulo . "_cartel." . $request->cartel-> extension();
                            $path = $request->cartel->storeAs('images', $nombre_cartel, 'public');
                            $pelicula->cartel = 'storage/'.$path;

                            $imgCropped = Image::make('storage/'.$path);
                            $imgCropped->resize(667, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->crop(667, 397, 0, 100)->encode('jpg');
                            $nombre_cartel_crop = $request->titulo . "_cartel." . $request->cartel-> extension();
                            Storage::disk('public')->put( 'cropImages/'.$nombre_cartel_crop, $imgCropped);

                            $imgCropped2 = Image::make('storage/'.$path);
                            $imgCropped2->resize(203, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->crop(203, 183, 0, 20)->encode('jpg');
                            $nombre_cartel_crop2 = $request->titulo . "_cartel." . $request->cartel-> extension();
                            Storage::disk('public')->put( 'cropImages2/'.$nombre_cartel_crop2, $imgCropped2);

                            $imgCropped3 = Image::make('storage/'.$path);
                            $imgCropped3->resize(201, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->crop(201, 290, 0, 20)->encode('jpg');
                            $nombre_cartel_crop3 = $request->titulo . "_cartel." . $request->cartel-> extension();
                            Storage::disk('public')->put( 'cropImages3/'.$nombre_cartel_crop3, $imgCropped3);
                        }
                    }

                    if ($request->hasFile('trailer')) {
                        if ($request->file('trailer')->isValid()) {
                            $nombre_trailer = $request->titulo . "_trailer." . $request->trailer-> extension();
                            $path = $request->trailer->storeAs('videos', $nombre_trailer, 'public');
                            $pelicula->trailer = 'storage/'.$path;
                        }
                    }
                    $pelicula->save();
                    return redirect()->route('admin_peliculas');

                }
            }
        } else {
            $validator = Validator::make($request->all(), [
                'titulo' => 'required',
                'director' => 'required',
                'guionistas' => 'required',
                'actores' => 'required',
                'categorias' => 'required|array',
                'sinopsis' => 'required',
                'duracion' => 'required|numeric',
                'estreno' => 'required|date'
            ]);

            if ($validator->fails()) {
                return redirect(route("formulario_pelicula"))
                    ->withErrors($validator)
                    ->withInput();
            } else {

                if (Pelicula::where('titulo', $request->titulo)
                    ->whereNotIn('id', [$request->id])
                    ->where('director', $request->director)
                    ->where('actores', $request->actores)
                    ->where('guionistas', $request->guionistas)
                    //->where('categorias', implode(', ', $request->categorias))
                    ->where('sinopsis', $request->sinopsis)
                    ->where('duracion', $request->duracion)
                    ->where('en_cartelera', true)
                    //->where('cartel', $request->cartel)
                    //->where('trailer', $request->trailer)
                    ->where('estreno', $request->estreno)
                    ->exists()) {

                    Session::flash('message', "La película actualizada ya existe en nuestros registros");
                    return back()->withInput();

                } else {
                    $pelicula = Pelicula::find($request->id);

                    $pelicula->titulo = $request->titulo;
                    $pelicula->director = $request->director;
                    $pelicula->guionistas = $request->guionistas;
                    $pelicula->actores = $request->actores;
                    $pelicula->categorias = implode(', ', $request->categorias);
                    $pelicula->sinopsis = $request->sinopsis;
                    $pelicula->duracion = $request->duracion;
                    $pelicula->estreno = $request->estreno;

                    if ($request->cartel!=null) {
                        if ($request->hasFile('cartel')) {
                            if ($request->file('cartel')->isValid()) {
                                $nombre_cartel = $request->titulo . "_cartel." . $request->cartel-> extension();
                                $path = $request->cartel->storeAs('images', $nombre_cartel, 'public');
                                $pelicula->cartel = 'storage/'.$path;

                                $imgCropped = Image::make('storage/'.$path);
                                $imgCropped->resize(667, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->crop(667, 397, 0, 100)->encode('jpg');
                                $nombre_cartel_crop = $request->titulo . "_cartel." . $request->cartel-> extension();
                                Storage::disk('public')->put( 'cropImages/'.$nombre_cartel_crop, $imgCropped);

                                $imgCropped2 = Image::make('storage/'.$path);
                                $imgCropped2->resize(203, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->crop(203, 183, 0, 20)->encode('jpg');
                                $nombre_cartel_crop2 = $request->titulo . "_cartel." . $request->cartel-> extension();
                                Storage::disk('public')->put( 'cropImages2/'.$nombre_cartel_crop2, $imgCropped2);

                                $imgCropped3 = Image::make('storage/'.$path);
                                $imgCropped3->resize(201, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->crop(201, 290, 0, 20)->encode('jpg');
                                $nombre_cartel_crop3 = $request->titulo . "_cartel." . $request->cartel-> extension();
                                Storage::disk('public')->put( 'cropImages3/'.$nombre_cartel_crop3, $imgCropped3);
                            }
                        }
                    }

                    if ($request->trailer!=null) {
                        if ($request->hasFile('trailer')) {
                            if ($request->file('trailer')->isValid()) {
                                $nombre_trailer = $request->titulo . "_trailer." . $request->trailer-> extension();
                                $path = $request->trailer->storeAs('videos', $nombre_trailer, 'public');
                                $pelicula->trailer = 'storage/'.$path;
                            }
                        }
                    }

                    $pelicula->save();
                    return redirect()->route('admin_peliculas');

                }
            }
        }
    }
}

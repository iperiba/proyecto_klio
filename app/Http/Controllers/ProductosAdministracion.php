<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Session;

class ProductosAdministracion extends Controller
{
    public function mostrar_todos_productos() {
        $todos_productos = Producto::paginate(10);
        return view('admin_productos', ['todos_productos' => $todos_productos]);
    }

    public function redireccion_formulario_productos(Request $request) {
        if ($request->id==0) {
            return view('formulario_productos');
        } else {
            $producto_modificar = Producto::find($request->id);
            return view('formulario_productos', ['producto_modificar' => $producto_modificar]);
        }
    }

    public function eliminar_producto(Request $request) {
        $Producto = Producto::find($request->id);
        $Producto->delete();
        return redirect()->route('admin_productos');
    }

    public function anadir_modificar_producto(Request $request)
    {
        $messages = [
            'nombre_producto.required' => 'El campo nombre es obligatorio',
            'precio.required' => 'El campo precio es obligatorio',
            'imagen_producto.required' => 'El campo imagen es obligatorio',
            'unique' => 'Nombre ya existente',
            'min' => 'El precio tiene que ser mayor que cero',
            'not_in' => 'El precio tiene que ser mayor que cero',
            'file' => 'Se debe adjuntar un archivo'
        ];

        if ($request->id == "0") {

            $validator = Validator::make($request->all(), [
                  'nombre_producto' => 'required|unique:productos,nombre',
                  'precio' => 'required|numeric|min:0|not_in:0',
                  'categoria' => 'required',
                  'imagen_producto' => 'required|file'
            ], $messages);

            if ($validator->fails()) {
                return redirect(route("formulario_productos"))
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $producto = new Producto();
                $producto->nombre = $request->nombre_producto;
                $producto->precio = $request->precio;
                $producto->categoria = $request->categoria;

                if ($request->hasFile('imagen_producto')) {
                    if ($request->file('imagen_producto')->isValid()) {
                        $nombre_imagen = $request->nombre_producto . $request->imagen_producto-> extension();
                        $path = $request->imagen_producto->storeAs('images', $nombre_imagen, 'public');
                        $producto->foto = 'storage/'.$path;

                        $imgCropped01 = Image::make('storage/'.$path);
                        $imgCropped01->resize(140, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->crop(140, 140, 0, 0)->encode('jpg');
                        $nombre_imagen_crop01 = $request->nombre_producto . $request->imagen_producto-> extension();
                        Storage::disk('public')->put( 'productCropImages/'.$nombre_imagen_crop01, $imgCropped01);
                    }
                }

                $producto->save();
                return redirect()->route('admin_productos');
            }
        } else {

            $validator = Validator::make($request->all(), [
                'nombre_producto' => 'required',
                'precio' => 'required|numeric|min:0|not_in:0',
                'categoria' => 'required',
            ], $messages);

            if ($validator->fails()) {
                return redirect(route("formulario_pelicula"))
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if (Producto::where('nombre', [$request->nombre_producto])
                    ->whereNotIn('id', [$request->id])
                    ->exists()) {

                    Session::flash('message', "Ya existe un producto con ese nombre");
                    return back()->withInput();

                } else {

                    $producto = Producto::find($request->id);
                    $producto->nombre = $request->nombre_producto;
                    $producto->precio = $request->precio;
                    $producto->categoria = $request->categoria;

                    if ($request->hasFile('imagen_producto')) {
                        if ($request->file('imagen_producto')->isValid()) {
                            $nombre_imagen = $request->nombre_producto . $request->imagen_producto-> extension();
                            $path = $request->imagen_producto->storeAs('images', $nombre_imagen, 'public');
                            $producto->foto = 'storage/'.$path;

                            $imgCropped01 = Image::make('storage/'.$path);
                            $imgCropped01->resize(140, null, function ($constraint) {
                                $constraint->aspectRatio();
                            })->crop(140, 140, 0, 0)->encode('jpg');
                            $nombre_imagen_crop01 = $request->nombre_producto . $request->imagen_producto-> extension();
                            Storage::disk('public')->put( 'productCropImages/'.$nombre_imagen_crop01, $imgCropped01);
                        }
                    }

                    $producto->save();
                    return redirect()->route('admin_productos');

                }
            }
        }
    }
}

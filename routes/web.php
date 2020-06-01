<?php

use App\Pelicula;
use App\Pelicula_Sala;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'VistasPaginas@redireccion_portada')->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

/*Route::get('/', function () {
    return view('home');
})->name('home');*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login_formulario', 'NuevoLoginController@autentificacion_ampliada')->name('login_formulario');

/* Rutas peliculas */

Route::get('/admin_peliculas', 'PeliculasAdministracion@mostrar_todas_peliculas')->name('admin_peliculas')->middleware('auth');

Route::get('/formulario_pelicula/{id?}', 'PeliculasAdministracion@redireccion_formulario_pelicula')->name('formulario_pelicula')->middleware('auth');

Route::post('/anadir_modificar_pelicula', 'PeliculasAdministracion@anadir_modificar_pelicula')->name('anadir_modificar_pelicula')->middleware('auth');

Route::get('/desactivar_pelicula/{id}', 'PeliculasAdministracion@desactivar_pelicula')->name('desactivar_pelicula')->middleware('auth');

/* Rutas salas */

Route::get('/admin_salas', 'SalasAdministracion@mostrar_todas_salas')->name('admin_salas')->middleware('auth');

Route::get('/formulario_sala/{id?}', 'SalasAdministracion@redireccion_formulario_sala')->name('formulario_sala')->middleware('auth');

Route::post('/anadir_modificar_sala', 'SalasAdministracion@anadir_modificar_sala')->name('anadir_modificar_sala')->middleware('auth');

Route::get('/eliminar_sala/{id}', 'SalasAdministracion@eliminar_sala')->name('eliminar_sala')->middleware('auth');

/* Rutas sesiones */

Route::match(['get', 'post'], '/admin_sesiones', 'SesionesAdministracion@mostrar_todas_sesiones')->name('admin_sesiones')->middleware('auth');

//Route::get('/formulario_sesion02', 'SesionesAdministracion@redireccion_formulario_sesion02')->name('formulario_sesion02')->middleware('auth');

Route::post('/formulario_sesion', 'SesionesAdministracion@redireccion_formulario_sesion')->name('formulario_sesion')->middleware('auth');

Route::post('comprobacion_fecha','SesionesAdministracion@comprobacion_fecha');

Route::post('comprobaciones_preSubmit','SesionesAdministracion@comprobaciones_preSubmit');

Route::post('/anadir_modificar_sesion', 'SesionesAdministracion@anadir_modificar_sesion')->name('anadir_modificar_sesion')->middleware('auth');

Route::get('/eliminar_sesion/{id}', 'SesionesAdministracion@eliminar_sesion')->name('eliminar_sesion')->middleware('auth');

/* Rutas productos */

Route::get('/admin_productos', 'ProductosAdministracion@mostrar_todos_productos')->name('admin_productos')->middleware('auth');

Route::match(['get', 'post'], '/formulario_productos', 'ProductosAdministracion@redireccion_formulario_productos')->name('formulario_productos')->middleware('auth');

Route::match(['get', 'post'], '/anadir_modificar_producto', 'ProductosAdministracion@anadir_modificar_producto')->name('anadir_modificar_producto')->middleware('auth');

Route::post('/eliminar_producto', 'ProductosAdministracion@eliminar_producto')->name('eliminar_producto')->middleware('auth');


/* Rutas single_pages */

Route::get('/about', 'VistasPaginas@redireccion_about')->name('about');

Route::get('/contact', 'VistasPaginas@redireccion_contact')->name('contact');

Route::get('/single/{id}', 'VistasPaginas@redireccion_single')->name('single');

/* Rutas seleccion asientos */

Route::post('seleccion_asientos01', 'Reservas@seleccion_asientos01')->name('seleccion_asientos01');

Route::post('comprobacion_vacio', 'Reservas@comprobacion_vacio')->name('comprobacion_vacio');

Route::post('comprobacion_email', 'Reservas@comprobacion_email')->name('comprobacion_email');

Route::post('seleccion_asientos02', 'Reservas@seleccion_asientos02')->name('seleccion_asientos02');

Route::post('seleccion_asientos03', 'Reservas@seleccion_asientos03')->name('seleccion_asientos03');

/* Rutas grupo peliculas */

Route::get('/review_general', 'VistasPaginas@redireccion_reviewGeneral')->name('review_general');

Route::get('/review_seleccionada', 'VistasPaginas@redireccion_reviewSeleccionada')->name('review_seleccionada');

Auth::routes();
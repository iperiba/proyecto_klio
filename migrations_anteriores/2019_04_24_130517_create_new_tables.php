<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateNewTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peliculas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo')->nullable(false);
            $table->string('director')->nullable(false);
            $table->string('guionistas')->nullable(false);
            $table->text('actores')->nullable(false);
            $table->string('categorias')->nullable(false);
            $table->string('cartel')->nullable(false);
            $table->text('sinopsis')->nullable(false);
            $table->string('trailer')->nullable(false);
            $table->integer('duracion')->nullable(false);
            $table->boolean('en_cartelera')->default(1);
            $table->date('estreno')->useCurrent();
            $table->timestamps();
        });

        Schema::create('salas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_sala')->nullable(false)->unique();
            $table->integer('largo')->nullable(false);
            $table->integer('ancho')->nullable(false);
            $table->timestamps();
        });

        Schema::create('pelicula_sala', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pelicula_id');
            $table->unsignedBigInteger('sala_id');
            /*$table->dateTime('sesion')->nullable(false);*/
            /*$table->date('dia')->default(Carbon::now()->format('Y-m-d'));
            $table->time('hora')->default(Carbon::now()->format('H:i:s'));*/
            $table->dateTime('fecha')->useCurrent();
            $table->longText('asientos')->nullable(false);
            $table->timestamps();
            $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');
            $table->foreign('sala_id')->references('id')->on('salas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_tables');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeliculasTable extends Migration
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
            $table->string('actores')->nullable(false);
            $table->string('categorias')->nullable(false);
            $table->string('cartel')->nullable(false);
            $table->text('sinopsis')->nullable(false);
            $table->string('trailer')->nullable(false);
            $table->integer('duracion')->nullable(false);
            $table->boolean('cartelera')->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peliculas');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreatePeliculaSalaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('pelicula_sala')) {
        } else {
            Schema::create('pelicula_sala', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('pelicula_id');
                $table->unsignedBigInteger('sala_id');
                /*$table->dateTime('sesion')->nullable(false);*/
                $table->date('dia')->default(Carbon::now()->format('Y-m-d'));
                $table->time('hora')->default(Carbon::now()->format('H:i:s'));
                $table->longText('asientos')->nullable(false);
                $table->timestamps();
                $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');
                $table->foreign('sala_id')->references('id')->on('salas')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelicula_sala');
    }
}

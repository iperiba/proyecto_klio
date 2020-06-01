<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaNuevaSalas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('salas')) {
        } else {
            Schema::create('salas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('codigo_sala')->nullable(false)->unique();
                $table->integer('largo')->nullable(false);
                $table->integer('ancho')->nullable(false);
                $table->timestamps();
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
        //
    }
}

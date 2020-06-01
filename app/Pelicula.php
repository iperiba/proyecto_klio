<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    protected $table = 'peliculas';

    public function salas()
    {
        return $this->belongsToMany('App\Sala')->withPivot('sesion', 'asientos')->withTimestamps();
    }
}

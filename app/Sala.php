<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'salas';

    public function peliculas()
    {
        return $this->belongsToMany('App\Pelicula')->withPivot('sesion', 'asientos')->withTimestamps();
    }
}

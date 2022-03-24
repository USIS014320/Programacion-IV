<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alumno extends Model
{
    protected $fillable = ['idAlumnp', 'codigo', 'nombre', 'direccion', 'telefono'];
}

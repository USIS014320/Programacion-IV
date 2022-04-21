<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class docente extends Model
{
    protected $fillable = ['idDocente','codigo','nombre','direccion','telefono','dui','idEscalafon'];
}

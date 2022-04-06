<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nota extends Model
{
    use HasFactory;
    protected $fillable = ['idNota','codigo','nombre','nota_1','nota_2','nota_3','nota_4','nota_5'];
}

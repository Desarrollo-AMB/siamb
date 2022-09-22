<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionTripulante extends Model
{
    use HasFactory;
    protected $table = 'funcion_tripulante';
    protected $fillable = [
        'funcion',
        'codigo'
    ];

}

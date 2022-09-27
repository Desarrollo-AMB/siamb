<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoFuncion extends Model
{
    use HasFactory;
    protected $table = 'empleado_funcion';
    protected $fillable = [
        'codigo_empleado',
        'id_funcion',
        'flag_jefe_maquina'
    ];
}

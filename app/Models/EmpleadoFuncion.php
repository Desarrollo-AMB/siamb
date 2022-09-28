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
        'id_funcion'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'codigo_empleado', 'codigo_empleado');
    }

}

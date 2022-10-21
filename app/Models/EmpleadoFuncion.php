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
        'codigo_grado',
        'id_funcion'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function grado_empleado()
    {
        return $this->belongsTo(GradosMilitares::class, 'codigo_grado', 'codigo_grado');
    }

}

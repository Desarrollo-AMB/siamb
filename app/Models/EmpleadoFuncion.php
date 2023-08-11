<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoFuncion extends Model
{
    use HasFactory;
    protected $table = 'empleado_funcion';
    protected $fillable = [
        '*'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function funcion_tripulante()
    {
        return $this->belongsTo(FuncionTripulante::class, 'id_funcion');
    }

    // public function grado_empleado()
    // {
    //     return $this->belongsTo(GradosMilitares::class, 'codigo_grado', 'codigo_grado');
    // }

    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function empleadoextra()
    {
        return $this->belongsTo(EmpleadosOtroComponente::class, 'codigo_empleado', 'codigo_empleado');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    use HasFactory;
    protected $table = 'nomina';

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function cargo() {
        return $this->hasOne(Cargos::class, 'codigo_cargo', 'codigo_cargo');
    }

    public function ubicacion() {
        return $this->hasOne(Ubicaciones::class, 'codigo_ubicacion', 'codigo_ubicacion');
    }

    public function tipo_empleado() {
        return $this->hasOne(TiposEmpleado::class, 'tipo_emp', 'tipo_emp');
    }
}

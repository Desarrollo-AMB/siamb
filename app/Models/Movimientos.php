<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Movimientos extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        '*'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('Tabla Movimientos')
        ->logOnly([
            'codigo_empleado', 'tipo_movimiento', 'ubicacion_anterior','cargo_anterior', 'codigo_ubicacion',
            'codigo_cargo', 'fecha_efectividad', 'observaciones','fecha_promocion','situacion',
            'tipo_emp_anterior', 'tipo_emp_nuevo', 'codigo_grado', 'codigo_grado_anterior','ubicacion_detallada',
            'ubicacion_detallada_anterior', 'fecha_ubicacion','fecha_ubicacion_anterior', 'resol_ubicacion',
            'resol_ubicacion_anterior', 'fecha_cargo', 'fecha_cargo_anterior', 'resol_cargo', 'resol_cargo_anterior',
            'observacion_cargo','observacion_cargo_anterior'
        ]);
    }
}

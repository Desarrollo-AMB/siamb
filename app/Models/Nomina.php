<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Nomina extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'nomina';
    protected $fillable = [
        '*',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function cargo() {
        return $this->hasOne(Cargos::class, 'codigo_cargo', 'codigo_cargo')->withTrashed();
    }

    public function ubicacion() {
        return $this->hasOne(Ubicaciones::class, 'codigo_ubicacion', 'codigo_ubicacion');
    }

    public function tipo_empleado() {
        return $this->belongsTo(TiposEmpleado::class, 'tipo_emp', 'tipo_emp');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('Actividad tabla nomina')
        ->logOnly(
            [
                'codigo_empleado', 'codigo_ubicacion', 'codigo_cargo', 'tipo_emp', 'fecha_ingreso',
                'codigo_banco', 'tipo_cuenta', 'nro_cuenta', 'situacion', 'sueldo',
                'codigo_ubicacion_detallada', 'fecha_egreso', 'observaciones'
            ]);
    }

    public function datos_militares() {
        return $this->hasOne(DatosMilitares::class, 'codigo_empleado', 'codigo_empleado');
    }
}

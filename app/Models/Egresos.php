<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Egresos extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        '*'
    ];

    public function empleado() {
        return $this->hasOne(Empleado::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function nomina() {
        return $this->hasOne(Nomina::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function tipo_de_baja() {
        return $this->hasOne(TipoDeBaja::class, 'tipo_egreso', 'causa_egreso');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('Tabla Egresos')
        ->logOnly([
            'codigo_empleado', 'fecha_salida',
            'causa_egreso','nro_resuelto',
            'fecha_resuelto','fecha_registro',
            'usuario'
        ]);
    }
}

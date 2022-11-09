<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Familiares extends Model
{
    use HasFactory, LogsActivity;
    
    protected $table = 'familiares';
    
    protected $fillable = [
        '*'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class,'codigo_empleado','codigo_empleado');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('Actividad tabla familiares')
        ->logOnly(
            [
                'codigo_empleado', 'numero_familiar', 'cedula_familiar', 'nombre1', 'nombre2', 
                'apellido1', 'apellido2', 'parentesco', 'fecha_nacimiento', 'sexo', 
                'edo_civil', 'nivel_instruccion', 'pendiente', 'estudia', 'tiene_beca',
                'status', 'fecha_registro', 'especial', 'hcm', 'asistencia_medica',
                'fecha_fallecimiento', 'nacionalidad', 'telefono_oficina', 'telefono_movil', 'correo_electronico',
                'profesion', 'vive', 'direccion', 'telefono_habitacion', 'fecha_salida_f',
                'fecha_boda', 'fecha_ingreso_f', 'discapacidad'
            ]);
    }
}

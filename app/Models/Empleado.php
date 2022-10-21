<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Empleado extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'empleados';

    protected $fillable = [
        '*',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nomina() {
        return $this->hasOne(Nomina::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function funcion() {
        return $this->hasMany(EmpleadoFuncion::class, 'codigo_empleado');
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('Actividad tabla empleado')
        ->logOnly(
            [
                'codigo_empleado', 'cedula', 'nombre1', 'nombre2', 'apellido1',
                'apellido2', 'situacion', 'fecha_nacimi', 'sexo', 'edo_civil',
                'telefono', 'nivel_instruccion', 'nacionalidad', 'direccion', 'ciudad',
                'estado', 'cod_postal', 'cta_ahorro_hab', 'foto'
            ]);
    }

    public function datos_militares() {
        return $this->hasOne(DatosMilitares::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function estudios_realizados() {
        return $this->hasOne(EstudiosRealizados::class, 'codigo_empleado', 'codigo_empleado');
    }
    /*public function getSituacionAttribute()
    {
        switch ($this->situacion) {
            case 'A':
                $value= 'ACTIVO';
                break;
            case 'E':
                $value= 'EGRESADO';
                break;
            case 'S':
                $value= 'SUSPENDIDO';
                break;
            case 'I':
                $value= 'INGRESO';
                break;
            default:
                $value= '';
                break;
        }
        return  $value;
    }*/
}

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

    // Relacion Muchos a Muchos para asignar el Rol al Empleado...
    public function rolesUser()
    {
        return $this->user->rolesUser();
    }

    public function nomina() {
        return $this->hasOne(Nomina::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function data_empleado()
    {
        return $this->belongsTo(Nomina::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function rol() {
        return $this->hasOne(Nomina::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function egresos()
    {
        return $this->belongsTo(Egresos::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function funcion() {
        return $this->hasMany(EmpleadoFuncion::class, 'codigo_empleado', 'codigo_empleado');
    }

    // Relacion Muchos a Muchos para asignar la Funcion Tripulante al Empleado...
    public function empleadoFuncion() {
        return $this->belongsToMany(FuncionTripulante::class, 'empleado_funcion', 'codigo_empleado','id_funcion','codigo_empleado');
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

    public function movimientos() {
        return $this->belongsTo(Movimientos::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function estudios_realizados() {
        return $this->hasOne(EstudiosRealizados::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function familiares()
    {
        return $this->hasMany(Familiares::class,'codigo_empleado','codigo_empleado');
    }

}

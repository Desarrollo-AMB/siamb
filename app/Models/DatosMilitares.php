<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DatosMilitares extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'datos_militares';
    protected $fillable = [
        '*',
    ];

    public function empleados() {
        return $this->hasOne(Empleados::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function categorias_militares() {
        return $this->hasOne(CategoriasMilitares::class, 'codigo_categoria', 'codigo_categoria');
    }

    public function promociones_militares() {
        return $this->hasOne(PromocionesMilitares::class, 'codigo_promocion', 'codigo_promocion');
    }

    public function especialidades_militares() {
        return $this->hasOne(EspecialidadesMilitares::class, 'codigo_especialidad', 'codigo_especialidad1');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('Actividad tabla datos_militares')
        ->logOnly(
            [
                'codigo_empleado', 'codigo_categoria', 'contingente'
            ]);
    }
}

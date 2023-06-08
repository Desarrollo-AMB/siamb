<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadosOtroComponente extends Model
{
    use HasFactory;
    protected $table = 'empleados_otro_componente';
    protected $fillable = [
        '*',
    ];
    public $timestamps = false;

    public function empleadoFuncion() {
        return $this->belongsToMany(FuncionTripulante::class, 'empleado_funcion', 'codigo_empleado','id_funcion','codigo_empleado');
     }
}

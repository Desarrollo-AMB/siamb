<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposEmpleado extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_empleados';

    protected $fillable = [
        'tipo_emp',
        'descripcion',
        'clasificacion',
        'codigo_cia',
        'aplicacion_nomina',
        'requiere_puesto',
    ];
    public $timestamps = false;

    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'tipo_emp', 'tipo_emp');
    }
}

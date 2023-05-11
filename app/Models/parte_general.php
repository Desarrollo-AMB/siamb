<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class parte_general extends Model
{
    use HasFactory;
    protected $table = 'parte_general';
    protected $fillable = [
        'codigo_empleado',
        'fecha',
        'codigo_ubicacion',
        'codigo_categoria',
        'grado_militar',
        'situacion',
        'observacion',
    ];
    public function ubicacion()
    {
        return $this->belongsTo(Ubicaciones::class, 'codigo_ubicacion');
    }
}

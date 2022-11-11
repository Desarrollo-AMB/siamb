<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilitaresCondecorados extends Model
{
    use HasFactory;

    protected $table = 'militares_condecorados';

    protected $fillable = [
        '*',
    ];

    public function condecoracion() {
    	return $this->hasOne(Condecoraciones::class, 'codigo_condecoracion', 'codigo_condecoracion');
    }
    
    public function empleados() {
    	return $this->hasOne(Empleado::class, 'codigo_empleado', 'codigo_empleado');
    }

    public function grado_militar()
    {
        return $this->belongsTo(GradosMilitares::class, 'codigo_grado', 'codigo_grado');
    }
}
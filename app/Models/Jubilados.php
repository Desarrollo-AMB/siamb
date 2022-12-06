<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jubilados extends Model
{
    use HasFactory;
    protected $table = 'jubilados';
    protected $fillable = [
        '*'
    ];

    public function tipo_empleado() {
        return $this->belongsTo(TiposEmpleado::class, 'tipo_emp', 'tipo_emp');
    }
}

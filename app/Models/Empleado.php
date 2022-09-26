<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $primaryKey = 'codigo_empleado';
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
    
}

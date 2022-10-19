<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradosMilitares extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'grados_militares';
    protected $fillable = [
        '*',
    ];

    public function grado() {
        return $this->hasMany(EmpleadoFuncion::class, 'codigo_grado');
    }
}

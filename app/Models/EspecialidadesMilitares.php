<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecialidadesMilitares extends Model
{
    protected $table = 'especialidades_militares';
    protected $fillable = [
        '*',
    ];

    public function datos_militares() {
        return $this->hasOne(DatosMilitares::class, 'codigo_especialidad1', 'codigo_especialidad');
    }
}

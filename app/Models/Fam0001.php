<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fam0001 extends Model
{
    use HasFactory;
    protected $table = 'fam0001';
    protected $fillable = [
        'fecha',
        'ov_ota_om',
        'componente_organismo',
        'unidad',
        'aeronave_modelo',
        'serial',
        'matricula',
        'base_estacion',
        'jefe_maquina',
        'completado',
        'user_id'
    ];
}

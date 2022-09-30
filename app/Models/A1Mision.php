<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class A1Mision extends Model
{
    use HasFactory;
    protected $table = 'a1_mision';
    protected $fillable = [
        'ordenada_por',
        'en_apoyo',
        'codigo',
        'ruta_desde',
        'ruta_hasta',
        'encend',
        'despeg',
        'aterriz',
        'apag',
        'registro_manual',
        'horometro',
        'ind_vuelo',
        'toque_desp',
        'low_go',
        'total',
        'ciclos_tren',
        'ov_ota_om',
        'fam0001_id',
        'completado',
    ];
}

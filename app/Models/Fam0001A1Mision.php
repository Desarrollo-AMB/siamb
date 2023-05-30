<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fam0001A1Mision extends Model
{
    use HasFactory;
    protected $table = 'fam0001_a1_mision';
    protected $fillable = [
        'vuelo',
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
        'ciclos_tren',
        'ov_ota_om',
        'fam0001_id',
        'en_apoyo_A2',
        'descripcion_A2',
        'completado',
        'user_id'
    ];

    public function consumibles() {
        return $this->hasMany(Fam0001A1MisionConsumible::class, 'fam0001_a1_mision_id');
    }

    public function fam0001()
    {
        return $this->belongsTo(Fam0001::class, 'fam0001_id');
    }
}

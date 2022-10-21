<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fam0001A1MisionTotales extends Model
{
    use HasFactory;
    protected $table = 'fam0001_a1_mision_totales';
    protected $fillable = [
        'ov_ota_om',
        'fam0001_id',
        'fam0001_a1_mision_id',
        'total_registro_manual',
        'total_ind_vuelo',
        'total_toque_desp',
        'total_low_go',
        'total_aterriz',
        'total_ciclos_tren',
        'total_consumibles',
    ];
}

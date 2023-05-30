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
        'total_registro_manual',
        'total_ind_vuelo',
        'total_toque_desp',
        'total_low_go',
        'total_aterriz',
        'total_ciclos_tren',
        'total_consumibles',
        'user_id'
    ];

    public function aeronaves()
    {
        return $this->belongsTo(AeronaveModelo::class, 'aeronave_modelo');
    }
    public function base()
    {
        return $this->belongsTo(Base::class, 'base_estacion');
    }
    public function misiones()
    {
        return $this->hasMany(Fam0001A1Mision::class, 'fam0001_id');
    }
}

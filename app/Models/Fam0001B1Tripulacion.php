<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fam0001B1Tripulacion extends Model
{
    use HasFactory;
    protected $table = 'fam0001_b1_tripulacion';
    protected $fillable = [
        'ov_ota_om',
        'fam0001_id',
        'fam0001_a1_mision_id',
        'v_trip',
        'grado_nombre_id',
        'grado_nombre_data',
        'cedula',
        'funcion',
        'codigo_funcion',
        'tipo_despegue',
        'operaciones_en_vuelo',
        'aterrizaje', 
        'COD',
        'hv',
        'completado',
    ];

    public function funcionTrip() {
        return $this->belongsTo(FuncionTripulante::class, 'funcion');
    }

}

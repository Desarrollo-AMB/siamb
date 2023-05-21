<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramacionVuelo extends Model
{
    use HasFactory;

    protected $table = 'programacion_vuelo';

    protected $fillable = [
        'fam0001_id',
        'fam0001_a1_mision_id',
        'fecha',
        'unidad',
        'sistema_matricula',
        'matriculas_alternas',
        'ordenada_por',
        'mision_ruta',
        'salida',
        'retorno',
        'militar',
        'civil',
        'carga',
        // Otros campos que deseas llenar
    ];
}

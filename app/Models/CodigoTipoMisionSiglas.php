<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoTipoMisionSiglas extends Model
{
    use HasFactory;
    protected $table = 'vuelo_codigo_siglas_mision';
    protected $fillable = [
        'siglas',
        'nombre'
    ];

}

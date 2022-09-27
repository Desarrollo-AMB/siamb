<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoTipoMision extends Model
{
    use HasFactory;
    protected $table = 'vuelo_codigo_tipo_mision';
    protected $fillable = [
        'codigo'
    ];
}

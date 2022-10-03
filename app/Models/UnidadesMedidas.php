<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesMedidas extends Model
{
    use HasFactory;
    protected $table = 'unidades_medidas';
    protected $fillable = [
        'unidad'
    ];
}

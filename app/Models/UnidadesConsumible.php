<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesConsumible extends Model
{
    use HasFactory;
    protected $table = 'unidades_consumible';
    protected $fillable = [
        'consumible',
        'tipo',
        'unidad'
    ];
}

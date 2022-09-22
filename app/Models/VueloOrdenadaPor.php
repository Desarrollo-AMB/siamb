<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VueloOrdenadaPor extends Model
{
    use HasFactory;
    protected $table = 'vuelo_ordenada_por';
    protected $fillable = [
        'autoridad_orden_vuelo',
        'codigo'
    ];
}

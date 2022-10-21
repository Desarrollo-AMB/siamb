<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoAterrizaje extends Model
{
    use HasFactory;
    protected $table = 'codigo_aterrizaje';
    protected $fillable = [
        'tipo_aterrizaje',
        'codigo'
    ];
}

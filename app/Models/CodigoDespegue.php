<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoDespegue extends Model
{
    use HasFactory;
    protected $table = 'codigo_despegue';
    protected $fillable = [
        'tipo_despegue',
        'codigo'
    ];
}

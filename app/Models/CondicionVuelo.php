<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CondicionVuelo extends Model
{
    use HasFactory;
    protected $table = 'condiciones_vuelo';
    protected $fillable = [
        'siglas',
        'nombre'
    ];
}

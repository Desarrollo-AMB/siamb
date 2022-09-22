<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VueloEnApoyo extends Model
{
    use HasFactory;
    protected $table = 'vuelo_en_apoyo';
    protected $fillable = [
        'nombre_apoyo',
        'codigo'
    ];
}

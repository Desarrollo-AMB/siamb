<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanciones extends Model
{
    use HasFactory;
    protected $table = 'datos_boleta';
    protected $fillable = [
        '*',
    ];
}

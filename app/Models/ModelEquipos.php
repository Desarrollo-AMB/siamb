<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEquipos extends Model
{
    use HasFactory;
    protected $table = 'equipos';
    protected $fillable = [
        '*'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursosRealizados extends Model
{
    use HasFactory;
    protected $table = 'cursos_realizados';
    protected $fillable = [
        '*',
    ];
}

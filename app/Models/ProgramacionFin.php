<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramacionFin extends Model
{
    use HasFactory;
    protected $table = 'progrmacion_fin';
    protected $fillable = [
        '*',
    ];
}

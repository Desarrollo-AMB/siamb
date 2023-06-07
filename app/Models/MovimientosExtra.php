<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientosExtra extends Model
{
    use HasFactory;
    protected $table = 'movimiento_extra';
    protected $fillable = [
        '*',
    ];
}

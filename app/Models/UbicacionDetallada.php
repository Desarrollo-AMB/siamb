<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbicacionDetallada extends Model
{
    use HasFactory;
    protected $table = 'ubicacion_detallada';
    protected $fillable = [
        '*',
    ];
    public $timestamps = false;
}

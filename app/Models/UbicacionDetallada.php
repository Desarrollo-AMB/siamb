<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UbicacionDetallada extends Model
{


    use HasFactory, SoftDeletes;
    protected $table = 'ubicacion_detallada';

    protected $dates = ['deleted_at'];
}

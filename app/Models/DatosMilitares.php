<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DatosMilitares extends Model
{
    use HasFactory, LogsActivity;


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('Actividad tabla datos_militares')
        ->logOnly(
            [
                'codigo_empleado', 'codigo_categoria', 'contingente'
            ]);
    }
}

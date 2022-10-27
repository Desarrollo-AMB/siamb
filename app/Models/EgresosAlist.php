<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EgresosAlist extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'egresos_alist';
    protected $fillable = [
        '*',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('Actividad tabla egresos_alist')
        ->logOnly(
            [
                'codigo_empleado', 'contingente', 'fecha_egreso', 'resolucion'
            ]);
    }
}

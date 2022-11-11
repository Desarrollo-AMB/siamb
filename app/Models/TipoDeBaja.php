<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TipoDeBaja extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tipo_de_baja';
    protected $fillable = [
        '*'
    ];

    public function egresos() {
        return $this->hasOne(Egresos::class, 'causa_egreso', 'tipo_egreso');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->useLogName('Tabla tipo_de_baja')
        ->logOnly([
            'codigo_egreso', 'descripcion'
        ]);
    }
}

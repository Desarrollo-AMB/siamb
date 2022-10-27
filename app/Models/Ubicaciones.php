<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        '*',
    ];
    
    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'codigo_ubicacion', 'codigo_ubicacion');
    }
}

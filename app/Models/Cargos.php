<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargos extends Model
{
    use HasFactory;
    
    protected $fillable = [
        '*',
    ];

    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'codigo_cargo', 'codigo_cargo');
    }
    
}

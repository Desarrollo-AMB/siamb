<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargos extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        '*',
    ];

    protected $dates = [
        'deleted_at',
    ];
    
    public function nomina()
    {
        return $this->belongsTo(Nomina::class, 'codigo_cargo', 'codigo_cargo');
    }
    
}

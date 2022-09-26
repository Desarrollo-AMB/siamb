<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponenteOrganismo extends Model
{
    use HasFactory;
    protected $table = 'componente_organismo';
    protected $fillable = [
        'componente',
        'organismo'
    ];
}

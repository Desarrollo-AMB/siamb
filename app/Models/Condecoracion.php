<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condecoracion extends Model
{
    use HasFactory;

    protected $table = 'condecoraciones';
    
    protected $fillable = [
        '*',
    ];

}

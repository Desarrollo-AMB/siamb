<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntelectualesCivil extends Model
{
    use HasFactory;
    protected $table = 'intelectuales_civil';
    protected $fillable = [
        '*'
    ];
}

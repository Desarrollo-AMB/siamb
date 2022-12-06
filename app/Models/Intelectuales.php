<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intelectuales extends Model
{
    use HasFactory;
    protected $table = 'intelectuales';
    protected $fillable = [
        '*'
    ];
}

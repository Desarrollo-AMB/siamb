<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelEventos extends Model
{
    use HasFactory;
    protected $table = 'eventos';
    protected $fillable = [
        '*'
    ];
}

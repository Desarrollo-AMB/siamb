<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paf extends Model
{
    use HasFactory;
    protected $table = 'paf';
    protected $fillable = [
        '*'
    ];
}

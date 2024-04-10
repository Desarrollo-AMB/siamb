<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelArmamento extends Model
{
    use HasFactory;
    protected $table = 'armamento';
    protected $fillable = [
        '*'
    ];


}

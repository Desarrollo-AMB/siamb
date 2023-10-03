<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorasVuelo extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'horas_vuelo';
    protected $fillable = [
        '*',
    ];

}

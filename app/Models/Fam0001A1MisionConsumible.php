<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fam0001A1MisionConsumible extends Model
{
    use HasFactory;
    protected $table = 'fam0001_a1_mision_consumibles';
    protected $fillable = [
        'ov_ota_om',
        'fam0001_id',
        'fam0001_a1_mision_id',
        'consumible',
        'unidad',
        'cantidad',
    ];
}

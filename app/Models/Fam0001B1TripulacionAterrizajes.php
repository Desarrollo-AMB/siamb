<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fam0001B1TripulacionAterrizajes extends Model
{
    use HasFactory;
    protected $table = 'fam0001_b1_trip_aterrizaje';
    protected $fillable = [
        'ov_ota_om',
        'fam0001_id',
        'fam0001_b1_mision_id',
        'TIP_ATERRIZAJE',
        'CANTIDAD',
    ];
}

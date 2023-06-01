<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fam0001A3CargaPasajeros extends Model
{
    use HasFactory;
    protected $table = 'fam0001_a3_carga';
    protected $fillable = [
        '*',
    ];

    public function carga()
    {
        return $this->belongsTo(Fam0001A1Mision::class, 'fam0001_a1_mision_id');
    }
}

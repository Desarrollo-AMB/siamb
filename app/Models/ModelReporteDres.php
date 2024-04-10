<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelReporteDres extends Model
{
    use HasFactory;
    protected $table = 'reportedres';
    protected $fillable = [
        '*'
    ];
}

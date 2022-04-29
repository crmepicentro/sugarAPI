<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConductorAuto extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'pvt_conductor_autos';
    protected $fillable = [
        'id',
        'conductor_id',
        'auto_id',
    ];
}

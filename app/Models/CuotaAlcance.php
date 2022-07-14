<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuotaAlcance extends Model
{
    use HasFactory;
    /*
        cambiar la conexion
        */
    protected $connection = 'sugar_dev';
    protected $table='cuota_alcance';
}

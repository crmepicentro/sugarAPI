<?php

namespace App\Models\CuotaAlcance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuotaArchivo extends Model
{
    use HasFactory;
        /*
        cambiar la conexion
        protected $connection = 'sugar_dev';
    */
    protected $table='bb_cuota_archivos';
    protected $fillable=[
        'id_cuota_alcance',
        'nombre',
        'tipo',
        'borrado'
    ];
}

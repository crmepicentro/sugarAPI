<?php

namespace App\Models\SolicitudCredito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudArchivo extends Model
{
    use HasFactory;
        /*
        cambiar la conexion
        */
    protected $connection = 'sugar_dev';
    protected $table='bb_solicitud_archivos';
    protected $fillable=[
        'id_solicitud',
        'nombre',
        'borrado'
    ];
}

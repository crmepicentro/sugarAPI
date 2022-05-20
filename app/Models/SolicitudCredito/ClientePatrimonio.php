<?php

namespace App\Models\SolicitudCredito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientePatrimonio extends Model
{
    use HasFactory;
    /*
        cambiar la conexion
        protected $connection = 'sugar_dev';
    */
    protected $table='bb_solicitud_credito';
    protected $fillable=[
        'bien_inmueble',
        'ciudad_direccion',
        'hipotecado',
        'marca_vehiculo',
        'modelo_vehiculo',
        'anio',
        'prendado',
        'valor_comercial',
        'patrimonio_tipo'
    ];
}

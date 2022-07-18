<?php

namespace App\Models\SolicitudCredito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientePatrimonio extends Model
{
    use HasFactory;
    /*
        cambiar la conexion
        */
    protected $connection = 'base_intermedia';
    protected $table='bb_solicitud_cliente_patrimonios';
    protected $fillable=[
        'bien_inmueble',
        'ciudad_direccion',
        'hipotecado',
        'marca_vehiculo',
        'modelo_vehiculo',
        'anio',
        'prendado',
        'valor_comercial',
        'cliente_id',
        'patrimonio_tipo'
    ];
}

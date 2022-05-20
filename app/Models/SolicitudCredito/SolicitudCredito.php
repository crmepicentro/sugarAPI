<?php

namespace App\Models\SolicitudCredito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCredito extends Model
{
    use HasFactory;
    /*
        cambiar la conexion
        protected $connection = 'sugar_dev';
    */
    protected $table='bb_solicitud_credito';
    protected $fillable=[
        'id_cotizacion',
        'producto',
        'valor_producto',
        'entrada',
        'valor_financiar',
        'plazo',
        'fecha_solicitud',
        'asesor',
        'agencia',
        'cedula_cliente',
        'id_cb'
    ];

}

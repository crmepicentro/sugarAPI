<?php

namespace App\Models\SolicitudCredito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteReferencia extends Model
{
    use HasFactory;
    /*
        cambiar la conexion
        protected $connection = 'sugar_dev';
    */
    protected $table='bb_solicitud_cliente_referencias';
    protected $fillable=[
        'institucion_1',
        'cuenta_tipo_1',
        'no_cuenta_1',
        'tarjeta_tipo_1',
        'banco_emisor_1',
        'institucion_2',
        'cuenta_tipo_2',
        'no_cuenta_2',
        'tarjeta_tipo_2',
        'banco_emisor_2',
        'nombre_completo_1',
        'relacion_cliente_1',
        'ciudad_1',
        'telefono_1',
        'nombre_completo_2',
        'relacion_cliente_2',
        'ciudad_2',
        'telefono_2',
        'nombre_completo_3',
        'relacion_cliente_3',
        'ciudad_3',
        'telefono_3',
        'empresa_nombre_1',
        'empresa_ciudad_1',
        'empresa_telefono_1',
        'empresa_nombre_2',
        'empresa_ciudad_2',
        'empresa_telefono_2',
        'empresa_nombre_3',
        'empresa_ciudad_3',
        'empresa_telefono_3',
        'compra_nombre_completo',
        'compra_correo',
        'compra_celular',
        'compra_telefono',
        'compra_ext_telefono',
        'pago_nombre_completo',
        'pago_correo',
        'pago_celular',
        'pago_telefono',
        'pago_ext_telefono'
    ];
}

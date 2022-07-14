<?php

namespace App\Models\SolicitudCredito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteEmpresa extends Model
{
    use HasFactory;
    /*
        cambiar la conexion
    */
    protected $connection = 'base_intermedia';

    protected $table='bb_solicitud_cliente_empresa';
    protected $fillable=[
        'nombre',
        'situacion_laboral',
        'actividad',
        'cargo',
        'direccion',
        'tiempo_trabajo',
        'ext_telefono',
        'cyg_nombre',
        'cyg_situacion_laboral',
        'cyg_actividad',
        'cyg_cargo',
        'cyg_direccion',
        'cyg_tiempo_trabajo',
        'cyg_telefono',
        'cyg_ext_telefono',
        'razon_social',
        'actividad_economica',
        'ruc',
        'cosntitucion_anios',
        'cosntitucion_meses',
        'provincia',
        'ciudad',
        'calle_principal',
        'calle_secundaria',
        'no_casa',
        'sector',
        'telefono',
        'celular',
        'correo',
        'instalaciones',
        'sucursales',
        'total_pasivos',
        'total_activos',
        'total_patrimonio'
    ];
}

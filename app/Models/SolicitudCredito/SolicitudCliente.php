<?php

namespace App\Models\SolicitudCredito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCliente extends Model
{
    use HasFactory;
    /*
        cambiar la conexion
        protected $connection = 'sugar_dev';
    */
    protected $table='bb_solicitud_cliente';
    protected $fillable=[
        'nombre_completo',
        'cedula',
        'pasaporte',
        'ruc',
        'estado_civil',
        'separacion_bienes',
        'carga_familiar',
        'cyg_nombre_completo',
        'cyg_cedula',
        'provincia',
        'ciudad',
        'calle_principal',
        'calle_secundaria',
        'no_casa',
        'sector',
        'telefono',
        'celular',
        'correo',
        'casa_tipo',
        'tiempo_residencia',
        'sueldo_ventas',
        'otros_ingresos',
        'ingreso_total',
        'cyg_sueldo',
        'ingreso_familiar',
        'descripcion_otros_ingresos',
        'alimentacion',
        'arriendo_vivienda',
        'entidades_bancarias',
        'otros_gastos',
        'gastos_total',
        'empresa_id',
        'referencias_id',
        'persona_tipo'
    ];
}

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

    public function generarPDF($idSolicitud)
    {
        $solicitud = self::where('id_cotizacion', $idSolicitud)->first();
        $cliente = SolicitudCliente::where('cedula', $solicitud->cedula_cliente)
            ->join('bb_solicitud_cliente_empresa', 'bb_solicitud_cliente.empresa_id', '=', 'bb_solicitud_cliente_empresa.id')
            ->join('bb_solicitud_cliente_referencias', 'bb_solicitud_cliente.referencias_id', '=', 'bb_solicitud_cliente_empresa.id')
            ->first();
        return $cliente;
    }

}

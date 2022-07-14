<?php

namespace App\Models\SolicitudCredito;

use PDF;
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
        'financiamiento',
        'plazo',
        'fecha_solicitud',
        'asesor',
        'agencia',
        'cedula_cliente',
        'id_cb'
    ];

    public function generarPDF()
    {
        $objeto = $this;
        $solicitud = self::where('id_cotizacion', $objeto->id_cotizacion)->first();
        $cliente = SolicitudCliente::where('cedula', $solicitud->cedula_cliente)
            ->join('bb_solicitud_cliente_empresa', 'bb_solicitud_cliente.empresa_id', '=', 'bb_solicitud_cliente_empresa.id')
            ->join('bb_solicitud_cliente_referencias', 'bb_solicitud_cliente.referencias_id', '=', 'bb_solicitud_cliente_empresa.id')
            ->first();
        $patrimonios = ClientePatrimonio::where('cliente_id', $cliente->id)->get();
        $data = [
            'solicitud'=> $solicitud,
            'cliente'=> $cliente,
            'patrimonios'=> $patrimonios
        ];
        $pdf = PDF::loadView('solicitud.cbNatural', $data);
        return $pdf->output();
    }

}

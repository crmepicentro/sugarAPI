<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGestionOportunidades extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'pvt_detalle_gestion_oportunidades';
    protected $fillable = [
        'id',
        'ws_log_id',

        'auto_id',

        'oportunidad_id',

        'codAgencia',
        'nomAgencia',
        'ordTaller',
        'kmVehiculo',
        'kmRelVehiculo',
        'ordFechaCita',
        'ordFechaCrea',
        'ordFchaCierre',
        'codOrdAsesor',
        'nomOrdAsesor',

        'codServ',
        'descServ',
        'cantidad',
        'cargosCobrar',
        'tipoCL',
        'facturado',

        'tipoServ',
        'franquicia',

        'facturacion_fecha',
        'facturacion_agente',

        'perdida_fecha',
        'perdida_agente',

        'ganado_fecha',
        'ganado_factura',

        'estado_momento_consulta',

    ];
    public function getClaveunicaprincipalAttribute($value)
    {
        return md5("{$this->codAgencia}|{$this->ordTaller}|{$this->codServ}");
    }
    public function getClaveunicaprincipaljsonAttribute($value)
    {
        return json_encode([
            'id' => $this->id,
            'codAgencia' => $this->codAgencia,
            'ordTaller' => $this->ordTaller,
            'codServ' => $this->codServ,
        ]);
    }
    public function getClaveunicaprincipal64Attribute($value)
    {
        return base64_encode(json_encode([
            'id' => $this->id,
            'codAgencia' => $this->codAgencia,
            'ordTaller' => $this->ordTaller,
            'codServ' => $this->codServ,
        ]));
    }
}


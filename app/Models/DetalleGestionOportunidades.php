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

        'cita_fecha',
        's3s_codigo_seguimiento',

        'facturacion_fecha',
        'facturacion_agente',

        'perdida_fecha',
        'perdida_agente',
        'perdida_motivo',

        'ganado_fecha',
        'ganado_factura',

        'gestion_fecha',
        'gestion_tipo',

        'estado_momento_consulta',

    ];
    public function getClaveunicaprincipalAttribute($value)
    {
        return md5("{$this->codAgencia}|{$this->ordTaller}|{$this->codServ}");
    }

    /**
     * Filtro de detalle oporunidades para gestionar.
     * @param $value
     * @return false|string
     */
    public function scopeAgestionar($query)
    {
        return $query->Where(function($query) {
            $query
                ->whereNull('perdida_fecha')
                ->whereNull('ganado_fecha');
        });
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
    public function getClaveunicaprincipals3sAttribute($value)
    {
        return [
            'codAgencia' => $this->codAgencia,
            'ordTaller' => $this->ordTaller,
            'codServ' => $this->codServ,
        ];
    }
}


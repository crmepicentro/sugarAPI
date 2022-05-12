<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

        'codCliFactura',
        'nomUsuarioVista',

        'cita_fecha',
        's3s_codigo_seguimiento',

        'facturacion_fecha',
        'facturacion_agente',

        'perdida_fecha',
        'perdida_agente',
        'perdida_motivo',

        'ganado_fecha',
        'ganado_factura',

        'agendado_fecha',

        'gestion_fecha',
        'gestion_tipo',

        'estado_momento_consulta',

    ];
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('facturado', function (Builder $builder) {
            $builder->where('facturado', '=', 'N');
        });
    }
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
    public function scopeFacturado($query)
    {
        return $query->Where('facturado', '=', 'N');
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

    /**
     * Funcion solo para FUncion en Listado Auto Ordenes
     * @return mixed
     */
    public function getPrimergestioestadoAttribute()
    {
        if($this->id != null){
            $dato = GestionAgendadoDetalleOportunidades::where('detalle_gestion_oportunidad_id', $this->id)->orderby('created_at','desc')->first();
            if($dato != null){
                return $dato->tipo_gestion;
            }
        }
        $todos = DetalleGestionOportunidades::where('ordTaller', $this->ordTaller)->select('id')->get()->pluck('id')->toArray();
        $dato = GestionAgendadoDetalleOportunidades::whereIn('detalle_gestion_oportunidad_id', $todos )->orderby('created_at','desc')->first();
        if($dato != null){
            return $dato->tipo_gestion;
        }
        return 'Sin Gestion';
    }
    /**
     * Funcion solo para FUncion en Listado Auto Ordenes
     * @return mixed
     */
    public function getGestionestadosAttribute($value)
    {
        if($this->id != null){
            $dato = GestionAgendadoDetalleOportunidades::where('detalle_gestion_oportunidad_id', $this->id)->orderby('created_at','desc')->first();
            if($dato != null){
                return $dato->tipo_gestion;
            }
        }
        $todos = DetalleGestionOportunidades::where('ordTaller', $this->ordTaller)->select('id')->get()->pluck('id')->toArray();
        $dato = GestionAgendadoDetalleOportunidades::whereIn('detalle_gestion_oportunidad_id', $todos )
            ->selectRaw('tipo_gestion,\'\' as calocho')
            ->groupby('tipo_gestion')
            ->get()
            ;
        if($dato != null && $dato->count() > 0){
            return $dato->pluck('tipo_gestion')
                ->toArray();
        }
        return [];
        //return 'Sin Gestion';
    }
}


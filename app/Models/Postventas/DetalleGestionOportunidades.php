<?php

namespace App\Models\Postventas;

use App\Http\Controllers\Postventas\Servicios3sController;
use Carbon\Carbon;
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
        'codEstOrdTaller',

        'codCliFactura',
        'nomUsuarioVista',

        'cita_fecha',
        's3s_codigo_seguimiento',
        's3s_codigo_estado_taller',

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
    public function stock_repuestos()    {
        return $this->hasMany(StockRepuestos::class, 'codigoRepuesto', 'codServ')->activo();
    }
    public function getDescservtotalAttribute($value)
    {
        return "{$this->codServ}|{$this->descServ}";
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
    public function getNombreEstadoTallerAttribute(){
        $codigo = $this->s3s_codigo_estado_taller;
        switch ($codigo){
            case 'AA':
                return 'ORDENES DE CONCECIONARIOS';
            case 'BB':
                return 'ORDENES PARA AVALUOS (CB)';
            case '00':
                return 'COTIZACION';
            case '09':
                return 'ORDEN ANULADA';
            case '10':
                return 'ESPERA PARA RECEPCION';
            case '20':
                return 'ESPERA PARA SERVICIO';
            case '25':
                return 'RECEPCIÓN A DOMICILIO';
            case '30':
                return 'ASIGNADA AL TECNICO';
            case '40':
                return 'ESTA SIENDO ATENDIDO';
            case '50':
                return 'DETENIDO X NUEVO TRABAJO';
            case '51':
                return 'ESPERA DE PARTES';
            case '52':
                return 'ESPERA DE APROBACION';
            case '53':
                return 'BAJO SUBCONTRATO';
            case '54':
                return 'DETENIDO  X OTROS MOTIVOS';
            case '55':
                return 'FIN DE JORNADA';
            case '56':
                return 'ALMUERZO';
            case '60':
                return 'TAREA TERMINADA / INSPECCION';
            case '63':
                return 'EN ESPERA DE LAVADA';
            case '66':
                return 'VEHICULO LAVANDOSE';
            case '70':
                return 'PRE-FACTURA ASESOR';
            case '80':
                return 'ORDEN CERRADA';
            case '83':
                return 'EN ESPERA DE FACTURA';
        }
    }
    public function getClaveunicaprincipals3sAttribute($value)
    {
        return [
            'codAgencia' => $this->codAgencia,
            'codServ' => $this->codServ,
            'ordTallerRef' => $this->ordTaller,
        ];
    }
    public function getClaveunicaprincipals3svariableAttribute($value)
    {
        return [
            'tipoServ'  => $this->tipoServ,
            'tipoCL'  => $this->tipoCL,
            'codServ' => $this->codServ,
            'ordTallerRef' => $this->ordTaller,
            'cantidad'  => $this->cantidad,
            'cargosCobrar'  => $this->cargosCobrar,
            'franquicia'  => $this->franquicia,
            'bodega'  => 'CUM',
        ];
    }

    public function getIdgestionAttribute()
    {
        if($this->id != null){
            $dato = GestionAgendadoDetalleOportunidades::where('detalle_gestion_oportunidad_id', $this->id)->orderby('created_at','desc')->first();
            if($dato != null){
                return $dato->gestion_agendado_id;
            }
        }
        $todos = DetalleGestionOportunidades::where('ordTaller', $this->ordTaller)->select('id')->get()->pluck('id')->toArray();
        $dato = GestionAgendadoDetalleOportunidades::whereIn('detalle_gestion_oportunidad_id', $todos )->orderby('created_at','desc')->first();
        if($dato != null){
            return $dato->gestion_agendado_id;
        }
        return null;
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
    public function verificaStokSoft(DetalleGestionOportunidades  $detalleGestionOportunidades){
        $existe_stock = StockRepuestos::where('codigoRepuesto', $detalleGestionOportunidades->codServ)->activo();
        if($existe_stock->count() == 0 ){
            $servicios3sdrl =  new Servicios3sController();
            $respstock = $servicios3sdrl->consultaStock($detalleGestionOportunidades->codServ,$detalleGestionOportunidades->franquicia);
            if($respstock['nomMensaje'] == 'ERROR'){
                StockRepuestos::create([
                    'users_id'  => auth()->user()->id,
                    'franquicia' => $detalleGestionOportunidades->franquicia,
                    'bodega' => config('constants.pv_sin_stock'),
                    'codigoRepuesto'  => $detalleGestionOportunidades->codServ,
                    'cantExistencia'  => 0,
                    'available_at' => Carbon::now()->addHour(12),
                ]);
                return false;
            }
            $tiene_stock = false;
            foreach ($respstock['listaStockRepuestos'] as $stockactual){
                StockRepuestos::create([
                    'users_id'  => auth()->user()->id,
                    'franquicia' => $stockactual['franquicia'],
                    'bodega' => $stockactual['bodega'],
                    'codigoRepuesto'  => $stockactual['codigoRepuesto'],
                    'cantExistencia'  => $stockactual['cantExistencia'],
                    'available_at' => Carbon::now()->addHour(12),
                ]);
                $tiene_stock = true;
            }
            return $tiene_stock;
        }
        return true;
    }
    public function getStockavalibleAttribute(){
        return $this->getStockavaliblehardAttribute();
    }
    public function getStockavaliblesoftAttribute(){
        //hacer analisis de producto relativo.
        switch ($this->tipoServ) {
            case 'M':
            case 'S':
            case 'P':
                return true;
            case 'R':
            return $this->verificaStokSoft($this);
        }
        return true;
    }
    public function getStockavaliblehardAttribute(){
        StockRepuestos::where('codigoRepuesto', '=',$this->codServ)->delete();
        return $this->getStockavaliblesoftAttribute();
    }
    public function scopeDaroportunidadeslist($query)
    {
        return $query->whereIn('gestion_tipo',['nuevo','cita','recordatorio'])->groupby('codServ','descServ')->select('codServ','descServ')->get();
    }
    public function scopeDaroestadoslist($query)
    {
        return $query->where('facturado','N')->groupby('gestion_tipo','gestion_tipo')->select('gestion_tipo','gestion_tipo')->get();
    }
}


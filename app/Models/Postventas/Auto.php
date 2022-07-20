<?php

namespace App\Models\Postventas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auto extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'pvt_autos';
    protected $fillable = [
        'id',
        'propietario_id',
        'id_auto_s3s',
        'id_ws_logs',
        'placa',
        'chasis',
        'modelo',
        'descVehiculo',
        'marcaVehiculo',
        'anioVehiculo',
        'masterLocVehiculo',
        'katashikiVehiculo',
    ];


    public function propietario()
    {
        return $this->belongsTo('App\Models\Postventas\Propietario');
    }
    public function detalleGestionOportunidades()    {
        return $this->hasMany(DetalleGestionOportunidades::class, 'auto_id', 'id');
    }
    public function detalleGestionOportunidadesagestionar()    {
        return $this->hasMany(DetalleGestionOportunidades::class, 'auto_id', 'id')->agestionar();
    }
    public function getStockdeautoAttribute() {
        $query_d =  $this->hasMany(DetalleGestionOportunidades::class, 'auto_id', 'id')->agestionar()
            ->Leftjoin((new StockRepuestos())->getTable(), function ($join) {
                $join->on('pvt_detalle_gestion_oportunidades.codServ', '=', 'pvt_stock_repuestos.codigoRepuesto')
                    ->On('pvt_detalle_gestion_oportunidades.franquicia', '=', 'pvt_stock_repuestos.franquicia');
            })->selectRaw("pvt_detalle_gestion_oportunidades.auto_id,
       pvt_detalle_gestion_oportunidades.franquicia,
       pvt_detalle_gestion_oportunidades.codServ,
       pvt_detalle_gestion_oportunidades.tipoServ,
       SUM(pvt_detalle_gestion_oportunidades.cantidad) AS cantidad_reqerida,
       IF( pvt_detalle_gestion_oportunidades.tipoServ = 'R', SUM(pvt_stock_repuestos.cantExistencia),SUM(pvt_detalle_gestion_oportunidades.cantidad) ) AS cantidad_disponible")
            ->groupby('pvt_detalle_gestion_oportunidades.codServ')
            ->groupby('pvt_detalle_gestion_oportunidades.franquicia')
            ->groupby('pvt_detalle_gestion_oportunidades.cantidad')
            ->groupby('pvt_detalle_gestion_oportunidades.tipoServ')
            ->groupby('pvt_detalle_gestion_oportunidades.auto_id')
        ;
        $total_necesario = 0;
        $total_existente = 0;
        foreach($query_d->get() as $stock){
            $total_necesario += $stock->cantidad_reqerida;
            $total_existente += min($stock->cantidad_reqerida,$stock->cantidad_disponible);
        }
        return ['stock_necesario' => $total_necesario , 'stock_existente' =>$total_existente ];
    }
    /**
     * Dar usuarios de auto
     */
    public function usuaariosautos()
    {
        return $this->belongsToMany(
            Usuarioauto::class,
            AutoUsuarioauto::class,
            'autos_id',
            'usuarioautos_id',
            'id',
            'id'
        );
    }
    public function usuaariosautosunicos()
    {
        return $this->belongsToMany(
            Usuarioauto::class,
            AutoUsuarioauto::class,
            'autos_id',
            'usuarioautos_id',
            'id',
            'id'
        )->distinct();
    }
    /**
     * Dar facturas de auto
     */
    public function facturas()
    {
        return $this->belongsToMany(
            Factura::class,
            AutoFactura::class,
            'autos_id',
            'factura_id',
            'id',
            'id'
        );
    }
    public function facturasunicos()
    {
        return $this->belongsToMany(
            Factura::class,
            AutoFactura::class,
            'autos_id',
            'factura_id',
            'id',
            'id'
        )->distinct();
    }
    public function scopeNombrepropietario($query, $nombre_propietario){
        if($nombre_propietario != null && trim($nombre_propietario) != ''){
            $propietarios = Propietario::where('nombre_propietario' ,'like', "%$nombre_propietario%")
                ->orwhere('email_propietario' ,'like', "%$nombre_propietario%")
                ->orwhere('email_propietario_2' ,'like', "%$nombre_propietario%")
                ->select('id')->get()->pluck('id');
            return $query->whereIntegerInRaw('propietario_id', $propietarios);
        }
        return $query;
    }
    public function scopeChasis($query, $search_chasis){
        if($search_chasis != null && trim($search_chasis) != ''){
            return $query->where('chasis', 'LIKE', "%$search_chasis%");
        }
        return $query;
    }
    public function scopePlaca($query, $search_placa){
        if($search_placa != null && trim($search_placa) != ''){
            return $query->where('placa', 'LIKE', "%$search_placa%");
        }
        return $query;
    }
    public function scopeNombreasesor($query, $search_asesor){
        if($search_asesor != null && trim($search_asesor) != ''){
            $detalleGestioOportunidades = DetalleGestionOportunidades::
            where('codOrdAsesor' ,'like', "%$search_asesor%")
                ->orwhere('nomOrdAsesor' ,'like', "%$search_asesor%")
                ->select('auto_id')->get()->pluck('auto_id');
            return $query->whereIntegerInRaw('pvt_autos.id', $detalleGestioOportunidades);
        }
        return $query;
    }
    public function scopeOrdtaller($query, $search_orden){
        if($search_orden != null && trim($search_orden) != ''){
            $detalleGestioOportunidades = DetalleGestionOportunidades::
            where('ordTaller' ,'like', "%$search_orden%")
                ->select('auto_id')->get()->pluck('auto_id');
            return $query->whereIntegerInRaw('pvt_autos.id', $detalleGestioOportunidades);
        }
        return $query;
    }
    public function scopeOportunidades($query, $search_oportunidades){
        if($search_oportunidades != null && count($search_oportunidades) > 0){

            $add_value = "";
            $porte_k = count($search_oportunidades);
            $j = 1;
            foreach ($search_oportunidades as $k){
                $add_value .= "?";
                if( $j++ < $porte_k ){
                    $add_value .= ",";
                }
            }
            $data_select_raw = "select `auto_id`
from (
select auto_id,codServ from pvt_detalle_gestion_oportunidades
where `facturado` = 'N' group by auto_id,codServ) as templ
where `codServ` in ( $add_value )
 group by `auto_id` having COUNT(*) >= ?";

            $search_oportunidades[] = count($search_oportunidades) ;


            $detalleGestioOportunidades = DB::select($data_select_raw, $search_oportunidades );
            $arr = [];
            foreach($detalleGestioOportunidades as $row)
            {
                $arr[] = $row->auto_id ;
            }


            return $query->whereIntegerInRaw('pvt_autos.id', $arr);
        }
        return $query;
    }
    public function scopeAgencia($query, $search_agencia){
        if($search_agencia != null && trim($search_agencia) != ''){
            $detalleGestioOportunidades = DetalleGestionOportunidades::
            where('codAgencia' ,'like', "%$search_agencia%")
            ->orWhere('nomAgencia' ,'like', "%$search_agencia%")
                ->select('auto_id')->get()->pluck('auto_id');
            return $query->whereIntegerInRaw('pvt_autos.id', $detalleGestioOportunidades);
        }
        return $query;
    }
    //gestion_tipo
    public function scopeGestiontipo($query, $search_estados){
        if($search_estados != null && trim($search_estados) != ''){
            $detalleGestioOportunidades = DetalleGestionOportunidades::
            where('gestion_tipo' ,'=', $search_estados)
                ->select('auto_id')->get()->pluck('auto_id');
            return $query->whereIntegerInRaw('pvt_autos.id', $detalleGestioOportunidades);
        }
        return $query;
    }
    public function scopeGestionfecha($query, $search_fechaGestion_from, $search_fechaGestion_to){
        if($search_fechaGestion_from != null && trim($search_fechaGestion_from) != '' &&
            $search_fechaGestion_to != null && trim($search_fechaGestion_to) != ''
        ){
            $date_from = Carbon::createFromFormat('d/m/Y',  $search_fechaGestion_from);
            $date_to = Carbon::createFromFormat('d/m/Y',  $search_fechaGestion_to);
            $detalleGestioOportunidades = DetalleGestionOportunidades::
            whereBetween('gestion_fecha' , [$date_from,$date_to])
                ->select('auto_id')->get()->pluck('auto_id');
            return $query->whereIntegerInRaw('pvt_autos.id', $detalleGestioOportunidades);
        }
        return $query;
    }
    public function scopeFacturafecha($query, $search_fechaFactura_from, $search_fechaFactura_to){
        if($search_fechaFactura_from != null && trim($search_fechaFactura_from) != '' &&
            $search_fechaFactura_to != null && trim($search_fechaFactura_to) != ''
        ){
            $date_from = Carbon::createFromFormat('d/m/Y',  $search_fechaFactura_from);
            $date_to = Carbon::createFromFormat('d/m/Y',  $search_fechaFactura_to);
            $fecha_mysql = str_replace( config('constants.pv_dateFormat'),'%d-%m-%Y', config('constants.pv_dateFormat') );//d-m-Y
            $detalleGestioOportunidades = DetalleGestionOportunidades::
            whereRaw( "STR_TO_DATE('ordFchaCierre','$fecha_mysql') Between ? AND ? "  , [$date_from,$date_to])
                ->select('auto_id')->get()->pluck('auto_id');
            return $query->whereIntegerInRaw('pvt_autos.id', $detalleGestioOportunidades);
        }
        return $query;
    }
    public function scopeCitafecha($query, $search_fechacita_from, $search_fechacita_to){
        if($search_fechacita_from != null && trim($search_fechacita_from) != '' &&
            $search_fechacita_to != null && trim($search_fechacita_to) != ''
        ){
            $date_from = Carbon::createFromFormat('d/m/Y',  $search_fechacita_from);
            $date_to = Carbon::createFromFormat('d/m/Y',  $search_fechacita_to);
            $detalleGestioOportunidades = DetalleGestionOportunidades::
            whereBetween('cita_fecha' , [$date_from,$date_to])
                ->select('auto_id')->get()->pluck('auto_id');
            return $query->whereIntegerInRaw('pvt_autos.id', $detalleGestioOportunidades);
        }
        return $query;
    }
}

<?php

namespace App\Models;

use App\Models\Gestion\GestionCita;
use App\Observers\GestionAgendadoObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class GestionAgendado extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pvt_gestion_agendados';
    protected $fillable = [
        'id',
        'users_id',
        'codigo_seguimiento',
        'codigo_seguimiento_resp_s3s',
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class,  'users_id','id');
    }
    public function citas()    {
        return $this->hasMany(GestionCita::class, 'gestion_agendado_id', 'id');
    }
    public function detalleoportunidad()
    {
        return $this->belongsToMany(DetalleGestionOportunidades::class, 'pvt_gestion_agendado_detalle_op', 'gestion_agendado_id', 'detalle_gestion_oportunidad_id');
    }
    public function detalleoportunidadcitas()
    {
        return $this->belongsToMany(DetalleGestionOportunidades::class, 'pvt_gestion_agendado_detalle_op', 'gestion_agendado_id', 'detalle_gestion_oportunidad_id')
            ->where('tipo_gestion','=', 'cita');
    }
    /**
     * dar atributo de respuesta en json para el sistema s3s
     */
    public function getCitas3sAttribute(){
       $repuesta_data = [];
        /**
         * Esta funcion hace esta consulta:
         * SELECT DISTINCT
         * pvt_gestion_agendados.codigo_seguimiento,
         * pvt_gestion_agendado_detalle_op.observacion_cita,
         * pvt_gestion_agendado_detalle_op.agencia_cita,
         * pvt_autos.placa,
         * pvt_gestion_agendados.users_id,
         * pvt_gestion_agendado_detalle_op.gestion_agendado_id,
         * FROM pvt_autos
         * INNER JOIN pvt_detalle_gestion_oportunidades
         * ON pvt_detalle_gestion_oportunidades.auto_id = pvt_autos.id
         * INNER JOIN pvt_gestion_agendado_detalle_op
         * ON pvt_gestion_agendado_detalle_op.detalle_gestion_oportunidad_id = pvt_detalle_gestion_oportunidades.id
         * INNER JOIN pvt_gestion_agendados
         * ON pvt_gestion_agendado_detalle_op.gestion_agendado_id = pvt_gestion_agendados.id
         * WHERE pvt_gestion_agendados.id = 1";
         */
        $param = 'cita';
        $as_auto = Auto::join('pvt_detalle_gestion_oportunidades', 'pvt_detalle_gestion_oportunidades.auto_id', '=', 'pvt_autos.id')
            ->selectRaw('DISTINCT propietario_id, pvt_gestion_agendados.codigo_seguimiento, pvt_gestion_agendado_detalle_op.observacion_cita, pvt_gestion_agendado_detalle_op.agencia_cita,  pvt_autos.placa,  pvt_gestion_agendados.users_id,  pvt_gestion_agendado_detalle_op.gestion_agendado_id')
            //->join('pvt_gestion_agendado_detalle_op', 'pvt_gestion_agendado_detalle_op.detalle_gestion_oportunidad_id', '=', 'pvt_detalle_gestion_oportunidades.id')
            ->join('pvt_gestion_agendado_detalle_op', function($join) use ($param)
            {
                $join->on('pvt_gestion_agendado_detalle_op.detalle_gestion_oportunidad_id', '=', 'pvt_detalle_gestion_oportunidades.id')
                    ->where('tipo_gestion','=', $param);
            })
            ->join('pvt_gestion_agendados', 'pvt_gestion_agendado_detalle_op.gestion_agendado_id', '=', 'pvt_gestion_agendados.id')
            ->where('pvt_gestion_agendados.id', '=', $this->id)
            ->first();
        $repuesta_data = [
            'placaVehiculo' => $as_auto->placa,
            'idEmpresa' => config('constants.pv_empresa'),
            'usuarioCrea' => Auth::user()->name,
            'ciPropietario' => $as_auto->propietario->cedula,
            'codAgencia' => $as_auto->agencia_cita,
            'gestionComentario' => $as_auto->observacion_cita,
            'gestionId' => $as_auto->codigo_seguimiento,
            'ordTallerRef'=> '',
            'oportunidades'=>$this->detalleoportunidadcitas->pluck('claveunicaprincipals3s')->toArray(),
        ];
        return $repuesta_data;
    }
    public function autos()
    {
        return Auto::join('pvt_detalle_gestion_oportunidades', 'pvt_detalle_gestion_oportunidades.auto_id', '=', 'pvt_autos.id')
            ->selectRaw('distinct pvt_autos.*')
            ->join('pvt_gestion_agendado_detalle_op', 'pvt_gestion_agendado_detalle_op.detalle_gestion_oportunidad_id', '=', 'pvt_detalle_gestion_oportunidades.id')
            ->join('pvt_gestion_agendados', 'pvt_gestion_agendado_detalle_op.gestion_agendado_id', '=', 'pvt_gestion_agendados.id')
            ->where('pvt_gestion_agendados.id', '=', $this->id)
        ->get();
    }

}

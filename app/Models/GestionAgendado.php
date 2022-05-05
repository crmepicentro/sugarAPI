<?php

namespace App\Models;

use App\Models\Gestion\GestionCita;
use App\Observers\GestionAgendadoObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionAgendado extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pvt_gestion_agendados';
    protected $fillable = [
        'id',
        'users_id',
        'codigo_seguimiento',
    ];
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
        $as_autos = Auto::join('pvt_detalle_gestion_oportunidades', 'pvt_detalle_gestion_oportunidades.auto_id', '=', 'pvt_autos.id')
            ->selectRaw('DISTINCT  pvt_gestion_agendados.codigo_seguimiento, pvt_gestion_agendado_detalle_op.observacion_cita, pvt_gestion_agendado_detalle_op.agencia_cita,  pvt_autos.placa,  pvt_gestion_agendados.users_id,  pvt_gestion_agendado_detalle_op.gestion_agendado_id')
            //->join('pvt_gestion_agendado_detalle_op', 'pvt_gestion_agendado_detalle_op.detalle_gestion_oportunidad_id', '=', 'pvt_detalle_gestion_oportunidades.id')
            ->join('pvt_gestion_agendado_detalle_op', function($join) use ($param)
            {
                $join->on('pvt_gestion_agendado_detalle_op.detalle_gestion_oportunidad_id', '=', 'pvt_detalle_gestion_oportunidades.id')
                    ->where('tipo_gestion','=', $param);
            })
            ->join('pvt_gestion_agendados', 'pvt_gestion_agendado_detalle_op.gestion_agendado_id', '=', 'pvt_gestion_agendados.id')
            ->where('pvt_gestion_agendados.id', '=', $this->id)
            ->get();
        foreach ($as_autos as $as_auto){// es auto por gestion
            $repuesta_data[] = [
                'gestion_id' => $as_auto->codigo_seguimiento,
                'gestion_comentario' => $as_auto->observacion_cita,
                'codAgencia'=> $as_auto->agencia_cita,
                'placa_auto'=> $as_auto->placa,
                'user_name'=> $as_auto->users_id,
                'oportunidades'=>$this->detalleoportunidadcitas->pluck('claveunicaprincipals3s')->toArray(),
            ];
        }
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

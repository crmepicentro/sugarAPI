<?php

namespace App\Models;

use App\Observers\GestionAgendadoDetalleOportunidadesObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionAgendadoDetalleOportunidades extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pvt_gestion_agendado_detalle_op';

    public static $ESTADO_INICIAL_S3S = '0';
    public static $ESTADO_ACTIVO = '0';
    public static $ESTADO_INACTIVO = '1';//historico
    public static $SIN_MOTIVO_PERDIDA = '-SMP-';

    protected $fillable = [
        'id',
        'detalle_gestion_oportunidad_id',
        'gestion_agendado_id',
        'tipo_gestion',
        'activo',
        'estado_s3s',

        'fecha_agendamiento',
        'asunto_agendamiento',
        'observacion_agendamiento',
        'motivo_perdida',
        'observacion_cita',
        'agencia_cita',
    ];


    /**
     * observadores, son como eventos pero mas amplios, es como un triger en los modelos
     */
    public static function boot() {
        parent::boot();
        GestionAgendadoDetalleOportunidades::observe(new GestionAgendadoDetalleOportunidadesObserver());
    }

    public function scopeCita($query)
    {
        return $query->where('tipo_gestion', '=', 'cita');
    }
    public function scopeRecordatorio($query)
    {
        return $query->where('tipo_gestion', '=', 'recordatorio');
    }
    public function scopePerdido($query)
    {
        return $query->where('tipo_gestion', '=', 'perdido');
    }
    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', GestionAgendadoDetalleOportunidades::$ESTADO_ACTIVO);
    }
    public function detalleoportunidad()
    {
        return $this->belongsTo(DetalleGestionOportunidades::class, 'id', 'detalle_gestion_oportunidad_id');
    }
}

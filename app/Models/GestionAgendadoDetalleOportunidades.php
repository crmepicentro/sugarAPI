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

    protected $fillable = [
        'id',
        'detalle_gestion_oportunidad_id',
        'gestion_agendado_id',
        'estado_s3s',
        'activo'
    ];

    /**
     * observadores, son como eventos pero mas amplios, es como un triger en los modelos
     */
    public static function boot() {
        parent::boot();
        GestionAgendadoDetalleOportunidades::observe(new GestionAgendadoDetalleOportunidadesObserver());
    }
}

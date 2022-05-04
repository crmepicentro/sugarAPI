<?php

namespace App\Models\Gestion;

use App\Models\GestionAgendadoDetalleOportunidades;
use App\Observers\GestionAgendadoDetalleOportunidadesObserver;
use Illuminate\Database\Eloquent\Builder;

class GestionRecordatorio extends GestionAgendadoDetalleOportunidades
{
    public static function boot() {
        parent::boot();
        GestionRecordatorio::observe(new GestionAgendadoDetalleOportunidadesObserver());
    }
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('tipo_gestion', function (Builder $builder) {
            $builder->where('tipo_gestion', 'recordatorio');
        });
    }

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [ // consultar en el super, al ser protected no puede heredar de static.
        'tipo_gestion' => 'recordatorio',
        'activo' => '0',// GestionAgendadoDetalleOportunidades::$ESTADO_ACTIVO,
        'estado_s3s' => '0',// GestionAgendadoDetalleOportunidades::$ESTADO_INICIAL_S3S,
        'motivo_perdida' => '-SMP-',// gestionAgendadoDetalleOportunidades::$SIN_MOTIVO_PERDIDA,
        'agencia_cita' => null,
    ];


}

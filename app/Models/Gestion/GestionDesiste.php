<?php

namespace App\Models\Gestion;

use App\Models\GestionAgendadoDetalleOportunidades;
use App\Observers\GestionAgendadoDetalleOportunidadesObserver;
use Illuminate\Database\Eloquent\Builder;

class GestionDesiste extends GestionAgendadoDetalleOportunidades
{
    public static function boot() {
        parent::boot();
        GestionDesiste::observe(new GestionAgendadoDetalleOportunidadesObserver());
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
        'tipo_gestion' => 'perdido',
        'activo' => '0',// GestionAgendadoDetalleOportunidades::$ESTADO_ACTIVO,
        'estado_s3s' => '0',// GestionAgendadoDetalleOportunidades::$ESTADO_INICIAL_S3S,
        'fecha_agendamiento' => null,
    ];


}

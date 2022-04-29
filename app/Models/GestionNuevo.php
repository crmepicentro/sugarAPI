<?php

namespace App\Models;

use App\Observers\GestionNuevoObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionNuevo extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pvt_gestion_agendado_detalle_op';
    protected $fillable = [
        'id',
        'detalle_gestion_oportunidad_id',
        'users_id',
        'fecha_agendamiento',
        'observacion_agendamiento',
    ];

    /**
     * observadores, son como eventos pero mas amplios, es como un triger en los modelos
     */
    public static function boot() {
        parent::boot();
        GestionNuevo::observe(new GestionNuevoObserver());
    }

}

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

}

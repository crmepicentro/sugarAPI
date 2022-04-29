<?php

namespace App\Models;

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

}

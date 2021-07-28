<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ws_logs extends Model
{
    use HasFactory;

    protected $fillable = [
        'route',
        'datos_sugar_crm',
        'datos_adicionales',
        'response',
        'ticket_id',
        'interaccion_id',
        'environment',
        'source',
        'prospeccion_id',
        'call_id',
        'meeting_id'
    ];
}

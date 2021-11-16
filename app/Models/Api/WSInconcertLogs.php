<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WSInconcertLogs extends Model
{
    use HasFactory;
    protected $table = 'ws_inconcert_logs';
    protected $fillable = [
        'route',
        'environment',
        'fuente',
        'datos_sugar_crm',
        'datos_adicionales',
        'response_inconcert',
        'ticket_id',
        'interaction_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WsToyotaGo extends Model
{
    use HasFactory;

    protected $connection = 'base_temporal_api';
    protected $table = 'ws_toyotago_logs';

    protected $fillable = [
        'route',
        'environment',
        'source',
        'datos_principales',
        'datos_adicionales',
        'response',
        'status',
    ];
}

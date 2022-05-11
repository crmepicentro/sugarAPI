<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoFactura extends Model
{
    use HasFactory , SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pvt_auto_facturas';
    protected $fillable = [
        'id',
        'autos_id',
        'factura_id',
    ];
}

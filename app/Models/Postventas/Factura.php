<?php

namespace App\Models\Postventas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pvt_facturas';
    protected $fillable = [
        'id',
        'codCliFactura',
        'ciCliFactura',
        'nomCliFactura',
        'mail1CliFactura',
        'mali2CliFactura',
        'fonoCliDomFactura',
        'fonoCliTrabFactura',
        'fonoCliCelFactura',
    ];
}

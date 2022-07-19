<?php

namespace App\Models\Postventas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockRepuestos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pvt_stock_repuestos';
    protected $fillable = [
        'id',
        'users_id',
        'detalle_gestion_oportunidad_id',
        'franquicia',
        'bodega',
        'codigoRepuesto',
        'cantExistencia',
        'available_at',
    ];

    public function scopeActivo($query)
    {
        return $query->Where('available_at','>=', Carbon::now())->where('bodega','<>',config('constants.pv_sin_stock'));
    }
}

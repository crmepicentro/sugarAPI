<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'pvt_autos';
    protected $fillable = [
        'id',
        'propietario_id',
        'id_auto_s3s',
        'id_ws_logs',
        'placa',
        'chasis',
        'modelo',
        'descVehiculo',
        'marcaVehiculo',
        'anioVehiculo',
        'masterLocVehiculo',
        'katashikiVehiculo',
    ];


    public function propietario()
    {
        return $this->belongsTo('App\Models\Propietario');
    }
    public function detalleGestionOportunidades()    {
        return $this->hasMany(DetalleGestionOportunidades::class, 'auto_id', 'id');
    }

}

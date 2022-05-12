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
    public function detalleGestionOportunidadesagestionar()    {
        return $this->hasMany(DetalleGestionOportunidades::class, 'auto_id', 'id')->agestionar();
    }
    /**
     * Dar usuarios de auto
     */
    public function usuaariosautos()
    {
        return $this->belongsToMany(
            Usuarioauto::class,
            AutoUsuarioauto::class,
            'autos_id',
            'usuarioautos_id',
            'id',
            'id'
        );
    }
    public function usuaariosautosunicos()
    {
        return $this->belongsToMany(
            Usuarioauto::class,
            AutoUsuarioauto::class,
            'autos_id',
            'usuarioautos_id',
            'id',
            'id'
        )->distinct();
    }
    /**
     * Dar facturas de auto
     */
    public function facturas()
    {
        return $this->belongsToMany(
            Factura::class,
            AutoFactura::class,
            'autos_id',
            'factura_id',
            'id',
            'id'
        );
    }
    public function facturasunicos()
    {
        return $this->belongsToMany(
            Factura::class,
            AutoFactura::class,
            'autos_id',
            'factura_id',
            'id',
            'id'
        )->distinct();
    }

}

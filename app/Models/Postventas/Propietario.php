<?php

namespace App\Models\Postventas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory; // para crear registros con factory

    protected $connection = 'mysql';
    protected $table = 'pvt_propietarios';
    protected $fillable = [
        'id',
        'contact_id',
        'id_ws_logs',
        'cedula',
        'codPropietario',
        'nombre_propietario',
        'email_propietario',
        'email_propietario_2',
        'telefono_domicilio',
        'telefono_trabajo',
        'telefono_celular',
    ];
    public function autos()
    {
        return $this->hasMany(Auto::class, 'propietario_id', 'id');
    }
    public function autosgestion()
    {
        return $this->hasMany(Auto::class, 'propietario_id', 'id')
            ->selectRaw('pvt_autos.id,pvt_autos.placa,modelo,descVehiculo')
            ->join('pvt_detalle_gestion_oportunidades', 'auto_id', 'pvt_autos.id')
            ->whereNull('perdida_fecha')
            ->whereNull('ganado_fecha')
            ->groupBy('pvt_autos.id','pvt_autos.placa','modelo','descVehiculo');
            ;
    }
}

<?php

namespace App\Models;

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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'pvt_conductors';
    protected $fillable = [
        'id',
        'contact_id',
        'cedula',
        'nombre_usuario',
        'apellido_usuario',
        'telefono_usuario',
        'email_usuario',
    ];
}

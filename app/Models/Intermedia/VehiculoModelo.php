<?php

namespace App\Models\Intermedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculoModelo extends Model
{
    use HasFactory;

    protected $table = 'cb_vehiculo_modelo';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'id_marca', 'nombre'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection_bdd_intermedia());
    }
}

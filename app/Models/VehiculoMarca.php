<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculoMarca extends Model
{
    use HasFactory;

    protected $table = 'cb_vehiculo_marca';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'nombre'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection_bdd_intermedia());
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuente extends Model
{
    use HasFactory;

    protected $table = 'fuente';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'nombre', 'estado'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection_bdd_intermedia());
    }

    public function medios()
    {
        return $this->hasMany(Medio::Class);
    }
}

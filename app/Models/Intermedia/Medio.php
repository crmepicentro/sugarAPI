<?php

namespace App\Models\Intermedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medio extends Model
{
    use HasFactory;

    protected $connection = 'base_intermedia';
    protected $table = 'medio';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'nombre', 'fuente_id', 'estado', 'automatico', 'ticket', 'prospeccion', 'trafico'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection_bdd_intermedia());
    }

    public function fuentes()
    {
        return $this->belongsTo(Fuente::class);
    }
 }

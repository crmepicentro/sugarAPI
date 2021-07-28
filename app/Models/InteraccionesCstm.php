<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteraccionesCstm extends Model
{
    use HasFactory;
    protected $table = 'cbt_interaccion_digital_cstm';
    protected $connection = 'sugar_dev';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id_c';
    protected $fillable = [
        'id_c',
        'fuente_descripcion_c',
        'anio_c',
        'asunto_c',
        'campaign_id_c',
        'color_c',
        'comentario_cliente_c',
        'estado_c',
        'id_interaccion_inconcert_c',
        'kilometraje_c',
        'marca_c',
        'modelo_list_c',
        'motivo_cierre_c',
        'placa_c',
        'tipo_transaccion_c',
        'medio_c'
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function interacciones()
    {
        return $this->belongsTo(Interacciones::class, 'id_c');
    }
}

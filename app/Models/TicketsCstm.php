<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketsCstm extends Model
{
    use HasFactory;
    protected $table = 'cbt_tickets_cstm';
    protected $connection = 'sugar_dev';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id_c';
    protected $fillable = [
        'id_c',
        'fecha_primera_modificacion_c',
        'user_id_c',
        'flag_estados_c',
        'equipo_c',
        'marca_c',
        'modelo_c',
        'anio_c',
        'placa_c',
        'kilometraje_c',
        'color_c',
        'tipo_transaccion_c',
        'asunto_c',
        'comentario_cliente_c',
        'id_interaccion_inconcert_c',
        'porcentaje_discapacidad_c',
        'medio_c',
        'campaign_id_c'
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function tickets()
    {
        return $this->belongsTo(Tickets::class, 'id_c');
    }
}

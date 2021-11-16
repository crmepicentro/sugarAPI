<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallsCstm extends Model
{
    use HasFactory;
    protected $table = 'calls_cstm';
    protected $connection = 'sugar_dev';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id_c';
    protected $fillable = [
        'id_c',
        'categoria_llamada_c',
        'comentario_accesorios_c',
        'comentario_postventa_c',
        'comentario_vehiculo_c',
        'fecha_14_dias_c',
        'fecha_mantenimiento_agendada_c',
        'fecha_salida_c',
        'kilometraje_c',
        'llamada_automatica_c',
        'nivel_satisfaccion_c',
        'novedades_c',
        'recomendaria_comprar_toyota_c',
        'tiene_quejas_c',
        'usuario_salida_c',
        'volveria_comprar_toyota_c',
        'referidos_c',
        'info_contacto_c',
        'origen_creacion_c',
        'cb_agencias_id_c',
        'tipo_llamada_c',
        'meeting_id_c'
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function calls()
    {
        return $this->belongsTo(Calls::class, 'id_c');
    }
}

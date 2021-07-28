<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspeccionCstm extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cbp_prospeccion_cstm';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id_c';
    protected $fillable = ['id_c',
        'tienetoyota_c',
        'modelo_c',
        'form_c',
        'motivo_cierre_c',
        'fecha_primera_modificacion_c',
        'user_id_c',
        'flag_estados_c',
        'interesado_renovacion_c',
        'correo_asesor_servicio_c',
        'nombre_asesor_servicio_c',
        'apellido_asesor_servicio_c',
        'hora_entrega_inmediata_c',
        'medio_c'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function prospeccion()
    {
        return $this->belongsTo(Prospeccion::class, 'id_c');
    }
}

<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cb_traficocontrol';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id',
        'name', 'date_entered', 'date_modified', 'modified_user_id',
        'created_by', 'description', 'deleted','assigned_user_id', 'team_id', 'team_seat_id',
        'hora_entrada', 'hora_salida', 'visita_tipo', 'brinda_identificacon', 'tipo_identificacion', 'numero_identificacion',
        'nombres', 'apellidos', 'celular', 'telefono', 'email', 'cb_lineanegocio_id_c', 'cb_agencias_id_c',
        'id_negociacion', 'estado', 'esta_interesado', 'tiempo_atencion', 'user_id1_c', 'revisado', 'fecha_revisado',
        'solicito_credito', 'realizo_test_drive', 'genero_hoja_opciones', 'solicito_avaluo', 'relizo_reserva',
        'cotizo','potencialidad','efectividad_medios','interes_vehiculo'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function lineaNegocio()
    {
        return $this->hasOne(BusinessLine::class, 'id', 'cb_lineanegocio_id_c');
    }

    public function talks()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Talks::class,
            'cb_negociacion_cb_traficocontrol_c',
            'cb_negociacion_cb_traficocontrolcb_traficocontrol_idb',
            'cb_negociacion_cb_traficocontrolcb_negociacion_ida');
    }
}

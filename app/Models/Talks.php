<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talks extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'cb_negociacion';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'date_entered', 'date_modified', 'modified_user_id', 'created_by',
        'description', 'deleted', 'team_id', 'team_set_id', 'assigned_user_id', 'brinda_identificacion',
        'numero_identificacion', 'tipo_identificacion', 'nombres',
        'apellidos', 'celular', 'telefono', 'email', 'fuente', 'fecha_inicio', 'fecha_fin',
        'user_id_c', 'cb_agencias_id_c', 'cb_lineanegocio_id_c', 'efectividad_medios', 'estado',
        'marca', 'modelo', 'placa', 'precio_cliente', 'precio_ofertado', 'solicito_credito', 'realizo_test_drive',
        'genero_hoja_opciones', 'solicito_avaluo', 'relizo_reserva', 'estado_venta', 'estado_negociacion',
        'analisis_cliente', 'currency_id', 'base_rate', 'ult_coment_asesor', 'ult_coment_coach', 'ult_coment_coord',
        'ult_fecha_visita', 'ult_fecha_coaching', 'auto_actual', 'interes_vehiculo', 'anio', 'kilometraje',
        'color_vehiculo', 'cotizo','potencialidad'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function trafico()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Traffic::class,
            'cb_negociacion_cb_traficocontrol_c',
            'cb_negociacion_cb_traficocontrolcb_negociacion_ida',
            'cb_negociacion_cb_traficocontrolcb_traficocontrol_idb');
    }

    public function calls()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Calls::class,
            'cb_negociacion_calls_c',
            'cb_negociacion_callscb_negociacion_ida',
            'cb_negociacion_callscalls_idb');
    }

    public function meetings()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Meetings::class,
            'cb_negociacion_meetings_c',
            'cb_negociacion_meetingscb_negociacion_ida',
            'cb_negociacion_meetingsmeetings_idb');
    }

    public function opportunities()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Opportunities::class,
            'cb_negociacion_opportunities_c',
            'cb_negociacion_opportunitiescb_negociacion_ida',
            'cb_negociacion_opportunitiesopportunities_idb');
    }

    public function appraisals()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Appraisals::class,
            'cb_negociacion_cb_avaluos_c',
            'cb_negociacion_cb_avaluoscb_avaluos_idb',
            'cb_negociacion_cb_avaluoscb_negociacion_ida');
    }
}

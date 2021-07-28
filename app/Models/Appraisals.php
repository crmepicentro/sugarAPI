<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appraisals extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cb_avaluos';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'date_entered', 'date_modified', 'modified_user_id', 'created_by',
        'description', 'deleted', 'cb_avaluos_type', 'lead_source',
        'amount', 'amount_usdollar', 'date_closed', 'next_step',
        'sales_stage', 'probability', 'cb_agencias_id_c', 'avaluadorsilencioso_fullname',
        'avaluadorsilencioso_username', 'color', 'fechaavaluosilencioso', 'fechaavaluotecnico',
        'fechasolicitudtecnico', 'fechatoma', 'km', 'marca',
        'modelo', 'motivo', 'numavaluo', 'numavaluotecnico','numavaluotoma', 'code',
        'codigo_u', 'count_av_tec', 'estadotecnico', 'placa','precioavaluotecnico', 'preciocliente','preciorecepcion',
        'team_id', 'team_set_id', 'assigned_user_id', 'team_id',
        'tipo', 'valor_esperado', 'currency_id', 'base_rate'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function talks()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Talks::class,
            'cb_negociacion_cb_avaluos_c',
            'cb_negociacion_cb_avaluoscb_negociacion_ida',
            'cb_negociacion_cb_avaluoscb_avaluos_idb');
    }
}

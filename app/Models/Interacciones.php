<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interacciones extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cbt_interaccion_digital';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'date_entered', 'description', 'deleted',
        'tipo_identificacion', 'numero_identificacion', 'nombre', 'apellidos',
        'celular', 'telefono', 'email', 'ciudad', 'modelo', 'fecha_compra',
        'forma_de_pago', 'estado_civil', 'ingreso_mensual', 'rango_buro',
        'linea_negocio', 'cb_agencias_id_c', 'cb_lineanegocio_id_c', 'fuente', 'assigned_user_id',
        'team_id'
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

     public function users()
     {
         return $this->belongsTo(Users::class, 'assigned_user_id');
     }

    public function interaccionesCstm()
    {
        return $this->hasOne(InteraccionesCstm::class, 'id_c', 'id');
    }

    public function lineaNegocio()
    {
        return $this->hasOne(BusinessLine::class, 'id', 'cb_lineanegocio_id_c');
    }

    public function tickets()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Tickets::class,
            'cbt_tickets_cbt_interaccion_digital_c',
            'cbt_tickets_cbt_interaccion_digitalcbt_interaccion_digital_idb',
            'cbt_tickets_cbt_interaccion_digitalcbt_tickets_ida');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->id = createdID();
        });
    }
}

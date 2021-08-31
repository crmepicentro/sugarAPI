<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tickets extends Model
{
    protected $connection = 'sugar_dev';
    protected $table = 'cbt_tickets';
    public $incrementing = false;
    const CREATED_AT = 'date_entered';
    const UPDATED_AT = 'date_modified';
    protected $fillable = ['id', 'name', 'date_entered', 'date_modified', 'modified_user_id', 'created_by',
        'description', 'deleted', 'numero_identificacion', 'tipo_identificacion', 'nombres',
        'apellidos', 'celular', 'telefono', 'email', 'fuente', 'brinda_identificacion', 'estado',
        'linea_negocio', 'proceso', 'ticket_id', 'team_id', 'team_set_id', 'assigned_user_id',
        'porcentaje_discapacidad_c'
    ];

    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function ticketsCstm()
    {
        return $this->hasOne(TicketsCstm::class, 'id_c', 'id');
    }

    public function interacciones()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Interacciones::class,
            'cbt_tickets_cbt_interaccion_digital_c',
            'cbt_tickets_cbt_interaccion_digitalcbt_tickets_ida',
            'cbt_tickets_cbt_interaccion_digitalcbt_interaccion_digital_idb');
    }

    public function calls()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Calls::class,
            'cbt_tickets_calls_c',
            'cbt_tickets_callscbt_tickets_ida',
            'cbt_tickets_callscalls_idb');
    }

    public function prospeccion()
    {
        return $this->belongsToMany(
            Prospeccion::class,
            'cbp_prospeccion_cbt_tickets_1_c',
            'cbp_prospeccion_cbt_tickets_1cbt_tickets_idb',
            'cbp_prospeccion_cbt_tickets_1cbp_prospeccion_ida');
    }

    public function meetings()
    {
        return $this->belongsToMany(
            Meetings::class,
            'cbt_tickets_meetings_c',
            'cbt_tickets_meetingscbt_tickets_ida',
            'cbt_tickets_meetingsmeetings_idb');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->id = createdID();
            $autoincrement = Tickets::count();
            $query->name = env('TICKET_PREFIX', "TCK-").intval($autoincrement + 1);
            $query->date_entered = Carbon::now();
            $query->date_modified = Carbon::now();
            $query->deleted = 0;
        });
    }

    public function notes()
    {
        return $this->belongsToMany(
            Notes::class,
            'cbt_tickets_notes_c',
            'cbt_tickets_notescbt_tickets_ida',
            'cbt_tickets_notesnotes_idb');
    }

    public function contacts()
    {
        return $this->belongsToMany(
            Contacts::class,
            'cbt_tickets_contacts_c',
            'cbt_tickets_contactscbt_tickets_idb',
            'cbt_tickets_contactscontacts_ida');
    }
}

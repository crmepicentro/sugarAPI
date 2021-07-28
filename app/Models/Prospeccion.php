<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospeccion extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'cbp_prospeccion';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id',
        'name',
        'date_entered',
        'date_modified',
        'modified_user_id',
        'created_by',
        'description',
        'deleted',
        'numero_identificacion',
        'tipo_identificacion',
        'nombres',
        'apellidos',
        'celular',
        'telefono',
        'email',
        'fuente',
        'tipo_prospeccion',
        'estado',
        'team_id',
        'team_set_id',
        'assigned_user_id',
        'campaign_id_c',
        'brinda_identificacion',
        'cb_lineanegocio_id_c'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

  public static function getIdentificacionUserStatus($numero_identificacion)
  {
    return self::where('numero_identificacion', $numero_identificacion)
                ->whereIn('estado', [1, 2]);
  }

    public function prospeccionCstm()
    {
        return $this->hasOne(ProspeccionCstm::class, 'id_c', 'id');
    }

    public function calls()
    {
        return $this->belongsToMany(
            Calls::class,
            'cbp_prospeccion_calls_c',
            'cbp_prospeccion_callscbp_prospeccion_ida',
            'cbp_prospeccion_callscalls_idb');
    }

    public function contacts()
    {
        return $this->belongsToMany(
            Contacts::class,
            'cbp_prospeccion_contacts_c',
            'cbp_prospeccion_contactscbp_prospeccion_idb',
            'cbp_prospeccion_contactscontacts_ida');
    }

    public function meetings()
    {
        return $this->belongsToMany(
            Meetings::class,
            'cbp_prospeccion_meetings_c',
            'cbp_prospeccion_meetingscbp_prospeccion_ida',
            'cbp_prospeccion_meetingsmeetings_idb');
    }

    public function tickets()
    {
        return $this->belongsToMany(
            Tickets::class,
            'cbp_prospeccion_cbt_tickets_1_c',
            'cbp_prospeccion_cbt_tickets_1cbp_prospeccion_ida',
            'cbp_prospeccion_cbt_tickets_1cbt_tickets_idb');
    }

    public function lineaNegocio()
    {
        return $this->hasOne(BusinessLine::class, 'id', 'cb_lineanegocio_id_c');
    }

    public function notes()
    {
        return $this->belongsToMany(
            Notes::class,
            'cbp_prospeccion_notes_c',
            'cbp_prospeccion_notescbp_prospeccion_ida',
            'cbp_prospeccion_notesnotes_idb');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->id = createdID();
        });
    }



}

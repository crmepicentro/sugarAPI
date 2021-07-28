<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'contacts';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id_c',
        'name', 'date_entered', 'date_modified', 'modified_user_id',
        'created_by', 'description', 'deleted', 'first_name', 'last_name',
        'phone_home', 'phone_mobile'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function contactsCstm()
    {
        return $this->hasOne(ContactsCstm::class, 'id_c', 'id');
    }

    public function calls()
    {
        return $this->belongsToMany(
            Calls::class,
            'calls_contacts',
            'contact_id',
            'call_id');
    }

    public function prospeccion()
    {
        return $this->belongsToMany(
            Prospeccion::class,
            'cbp_prospeccion_contacts_c',
            'cbp_prospeccion_contactscontacts_ida',
            'cbp_prospeccion_contactscbp_prospeccion_idb');
    }

    public function meetings()
    {
        return $this->belongsToMany(
            Meetings::class,
            'meetings_contacts',
            'contact_id',
            'meeting_id');
    }

    public function tickets()
    {
        return $this->belongsToMany(
            Tickets::class,
            'cbt_tickets_contacts_c',
            'cbt_tickets_contactscontacts_ida',
            'cbt_tickets_contactscbt_tickets_idb');
    }

  public function emailAddress()
  {
        return $this->belongsToMany(
            EmailAddreses::class,
            'email_addr_bean_rel',
            'bean_id',
            'email_address_id');
  }

  protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->id = createdID();
        });
    }

  public static function contactExists($numeroidentificacion)
    {
        return self::where('deleted', 0)
                          ->join('contacts_cstm', 'contacts.id', '=', 'contacts_cstm.id_c')
                          ->where('contacts_cstm.numero_identificacion_c', $numeroidentificacion)
                          ->first();
    }

  public static function getForDocument($document, $type, $fields){
    return self::selectRaw(implode(',',$fields))
                ->join('contacts_cstm','id_c','contacts.id')
                ->leftJoin('email_addr_bean_rel', function ($join){
                  $join->on('bean_id','contacts.id')
                        ->where('email_addr_bean_rel.primary_address',1)
                        ->where('email_addr_bean_rel.deleted',0);
                })
                ->leftJoin('email_addresses', function ($join){
                  $join->on('email_addresses.id','email_addr_bean_rel.email_address_id')
                       ->where('email_addresses.deleted',0);
                })
                ->leftJoin('base_intermedia.cb_nacionalidad','cb_nacionalidad.id','contacts_cstm.nacionalidad_c')
                ->where('contacts.deleted',0)
                ->where('contacts_cstm.numero_identificacion_c',$document)
                ->where('contacts_cstm.tipo_identificacion_c',$type)
                ->first();
  }

}

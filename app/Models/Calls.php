<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Prophecy\Call\Call;

class Calls extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'calls';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id',
        'name', 'date_entered', 'date_modified', 'modified_user_id',
        'created_by', 'description', 'deleted', 'duration_hours', 'duration_minutes',
        'date_start', 'date_end', 'parent_type', 'status', 'direction', 'parent_id',
        'reminder_time', 'email_reminder_time', 'assigned_user_id', 'team_id', 'team_seat_id'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function callsCstm()
    {
        return $this->hasOne(CallsCstm::class, 'id_c', 'id');
    }

    public function tickets()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Tickets::class,
            'cbt_tickets_calls_c',
            'cbt_tickets_callscalls_idb',
            'cbt_tickets_callscbt_tickets_ida');
    }

    public function users()
    {
        return $this->belongsToMany(
            Users::class,
            'calls_users',
            'call_id',
            'user_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(
            Contacts::class,
            'calls_contacts',
            'call_id',
            'contact_id');
    }

    public function prospeccion()
    {
        return $this->belongsToMany(
            Prospeccion::class,
            'cbp_prospeccion_calls_c',
            'cbp_prospeccion_callscalls_idb',
            'cbp_prospeccion_callscbp_prospeccion_ida');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->id = createdID();
        });
    }

    public function talks()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Talks::class,
            'cb_negociacion_calls_c',
            'cb_negociacion_callscalls_idb',
            'cb_negociacion_callscb_negociacion_ida');
    }
}

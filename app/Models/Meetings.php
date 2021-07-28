<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Meetings extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'meetings';
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
        'location',
        'password',
        'join_url',
        'host_url',
        'displayed_url',
        'external_id',
        'creator',
        'duration_hours',
        'duration_minutes',
        'date_start',
        'date_end',
        'parent_type',
        'parent_id',
        'status',
        'type',
        'assigned_user_id',
        'team_id',
        'team_set_id',
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function meetingsCstm()
    {
        return $this->hasOne(MeetingsCstm::class, 'id_c', 'id');
    }

    public function prospeccion()
    {
        return $this->belongsToMany(
            Prospeccion::class,
            'cbp_prospeccion_meetings_c',
            'cbp_prospeccion_meetingsmeetings_idb',
            'cbp_prospeccion_meetingscbp_prospeccion_ida');
    }

    public function contacts()
    {
        return $this->belongsToMany(
            Contacts::class,
            'meetings_contacts',
            'meeting_id',
            'contact_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            Users::class,
            'meetings_users',
            'meeting_id',
            'user_id');
    }

    public function tickets()
    {
        return $this->belongsToMany(
            Tickets::class,
            'cbt_tickets_meetings_c',
            'cbt_tickets_meetingsmeetings_idb',
            'cbt_tickets_meetingscbt_tickets_ida');
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
            'cb_negociacion_meetings_c',
            'cb_negociacion_meetingsmeetings_idb',
            'cb_negociacion_meetingscb_negociacion_ida');
    }

    public static function getMissedMeetings()
    {
      return \DB::connection(get_connection())->select('
        SELECT id FROM meetings
            WHERE DATE(NOW())>DATE(DATE_ADD(date_start, INTERVAL -5 HOUR)) AND STATUS="Planned" AND deleted=0;
        ');

    }
}

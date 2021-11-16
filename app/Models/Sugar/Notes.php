<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'notes';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'date_entered', 'date_modified', 'modified_user_id', 'created_by',
        'description', 'deleted', 'assigned_user_id', 'team_id', 'team_set_id'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->id = createdID();
        });
    }

    public function tickets()
    {
        return $this->belongsToMany(
            Tickets::class,
            'cbt_tickets_notes_c',
            'cbt_tickets_notesnotes_idb',
            'cbt_tickets_notescbt_tickets_ida');
    }

    public function prospeccion()
    {
        return $this->belongsToMany(
            Prospeccion::class,
            'cbp_prospeccion_notes_c',
            'cbp_prospeccion_notesnotes_idb',
            'cbp_prospeccion_notescbp_prospeccion_ida');
    }
}

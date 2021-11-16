<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMeeting extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cbt_tickets_meetings_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['date_modified', 'deleted', 'cbt_tickets_meetingscbt_tickets_ida', 'cbt_tickets_meetingsmeetings_idb'];
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
}

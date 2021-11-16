<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersMeetings extends Model
{
    use HasFactory;

    protected $table = 'meetings_users';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'meeting_id', 'user_id', 'required', 'accept_status', 'date_modified', 'deleted'];
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

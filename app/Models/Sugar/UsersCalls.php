<?php

namespace App\Models\Sugar;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersCalls extends Model
{
    use HasFactory;

    protected $table = 'calls_users';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'call_id', 'user_id', 'required', 'accept_status', 'date_modified', 'deleted'];
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

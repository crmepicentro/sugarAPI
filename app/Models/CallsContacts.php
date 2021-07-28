<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallsContacts extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'calls_contacts';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['call_id', 'contact_id', 'required', 'accept_status', 'date_modified', 'deleted'];
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

<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketsContacts extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cbt_tickets_contacts_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['date_modified', 'deleted', 'cbt_tickets_contacts_c', 'cbt_tickets_contacts_c'];
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

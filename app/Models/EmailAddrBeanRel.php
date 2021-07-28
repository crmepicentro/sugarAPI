<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAddrBeanRel extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'email_addr_bean_rel';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id',
        'email_address_id',
        'bean_id',
        'bean_module',
        'primary_address',
        'reply_to_address',
        'date_created',
        'date_modified',
        'deleted'
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
}

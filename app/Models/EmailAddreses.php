<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAddreses extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'email_addresses';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id',
        'email_address',
        'email_address_caps',
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

    public function contacts()
    {
        return $this->belongsToMany(
            Contacts::class,
            'email_addr_bean_rel',
            'email_address_id',
            'bean_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->id = createdID();
        });
    }
}

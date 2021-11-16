<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketsInteracciones extends Model
{
    protected $connection = 'sugar_dev';
    protected $table = 'cbt_tickets_cbt_interaccion_digital_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['deleted', 'cbt_tickets_cbt_interaccion_digitalcbt_tickets_ida', 'cbt_tickets_cbt_interaccion_digitalcbt_interaccion_digital_idb'];
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
            $query->date_modified = Carbon::now();
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketsProspeccion extends Model
{
    use HasFactory;
    protected $table = 'cbp_prospeccion_cbt_tickets_1_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'date_modified', 'deleted', 'cbp_prospeccion_cbt_tickets_1cbp_prospeccion_ida', 'cbp_prospeccion_cbt_tickets_1cbt_tickets_idb'];
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

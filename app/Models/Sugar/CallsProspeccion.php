<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallsProspeccion extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'cbp_prospeccion_calls_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'date_modified', 'deleted', 'cbp_prospeccion_callscbp_prospeccion_ida', 'cbp_prospeccion_callscalls_idb'];
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

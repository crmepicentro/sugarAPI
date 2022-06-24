<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalksAppraisals extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cbav_avaluoscrm_cb_negociacion_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['date_modified', 'deleted', 'cbav_avaluoscrm_cb_negociacioncb_negociacion_ida', 'cbav_avaluoscrm_cb_negociacioncbav_avaluoscrm_idb'];
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

<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalksTraffic extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cb_negociacion_cb_traficocontrol_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['date_modified', 'deleted', 'cb_negociacion_cb_traficocontrolcb_negociacion_ida', 'cb_negociacion_cb_traficocontrolcb_traficocontrol_idb'];
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

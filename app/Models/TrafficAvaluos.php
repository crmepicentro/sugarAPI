<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficAvaluos extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cba_avaluos_cb_traficocontrol_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['deleted', 'cba_avaluos_cb_traficocontrolcba_avaluos_idb', 'cba_avaluos_cb_traficocontrolcb_traficocontrol_ida'];
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

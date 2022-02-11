<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagenes extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cbav_imagenesavaluocrm';
    public $incrementing = false;
    const CREATED_AT = 'date_entered';
    const UPDATED_AT = 'date_modified';
    protected $fillable = ['name', 'created_by',
        'modified_user_id', 'description',
        'deleted', 'imagen_path', 'orientacion',
        'assigned_user_id'];
    /**
     * @var mixed
     */

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
            $query->deleted = 0;
        });
    }

    public function avaluo()
    {
        return $this->belongsToMany(
            Avaluos::class,
            'cbav_imagenesavaluocrm_cbav_avaluoscrm_c',
            'cbav_imagenesavaluocrm_cbav_avaluoscrmcbav_imagenesavaluocrm_idb',
            'cbav_imagenesavaluocrm_cbav_avaluoscrmcbav_avaluoscrm_ida');
    }
}

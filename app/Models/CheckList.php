<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cbav_checklistavaluonew';
    public $incrementing = false;
    const CREATED_AT = 'date_entered';
    const UPDATED_AT = 'date_modified';
    protected $fillable = ['name',
        'modified_user_id', 'description',
        'deleted', 'item_description', 'item_id',
        'costo', 'estado', 'assigned_user_id'];
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
            'cbav_checklistavaluonew_cbav_avaluoscrm_c',
            'cbav_checkef44aluonew_idb',
            'cbav_checklistavaluonew_cbav_avaluoscrmcbav_avaluoscrm_ida');
    }

    public function checkListAvaluo()
    {
        return $this->hasMany( CheckListAvaluo::class, 'cbav_checkef44aluonew_idb','id' );
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cba_checklist_avaluo';
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
            CheckList::class,
            'cba_checklist_avaluo_cba_avaluos_c',
            'cba_checklist_avaluo_cba_avaluoscba_checklist_avaluo_idb',
            'cba_checklist_avaluo_cba_avaluoscba_avaluos_ida');
    }

    public function checkListAvaluo()
    {
        return $this->hasMany( CheckListAvaluo::class, 'cba_checklist_avaluo_cba_avaluoscba_checklist_avaluo_idb','id' );
    }
}

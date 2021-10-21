<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaluos extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cba_avaluos';
    public $incrementing = false;
    const CREATED_AT = 'date_entered';
    const UPDATED_AT = 'date_modified';
    protected $fillable = ['name',
        'description', 'placa',
        'marca', 'modelo', 'color',
        'recorrido', 'tipo_recorrido', 'currency_id', 'base_rate',
        'precio_final', 'precio_nuevo', 'precio_aprobado', 'precio_nuevo_mod', 'precio_final_mod',
        'estado_avaluo', 'fecha_aprobacion', 'observacion', 'comentario'];
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
            $autoincrement = intval(Avaluos::count() + 1);
            $query->name = env('AVALUO_PREFIX', "AVAL-").$autoincrement;
            $query->date_entered = Carbon::now();
            $query->date_modified = Carbon::now();
            $query->num_avaluo = $autoincrement;
            $query->deleted = 0;
        });
    }

    public function imagenes()
    {
        return $this->belongsToMany(
            Imagenes::class,
            'cba_imagenes_avaluo_cba_avaluos_c',
            'cba_imagenes_avaluo_cba_avaluoscba_avaluos_ida',
            'cba_imagenes_avaluo_cba_avaluoscba_imagenes_avaluo_idb');
    }

    public function checklist()
    {
        return $this->belongsToMany(
            CheckList::class,
            'cba_checklist_avaluo_cba_avaluos_c',
            'cba_checklist_avaluo_cba_avaluoscba_avaluos_ida',
            'cba_checklist_avaluo_cba_avaluoscba_checklist_avaluo_idb');
    }
}

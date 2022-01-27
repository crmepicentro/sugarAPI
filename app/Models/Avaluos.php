<?php

namespace App\Models;

use App\Models\Strapi\Brands;
use App\Models\Strapi\Colors;
use App\Models\Strapi\Descriptions;
use App\Models\Strapi\Models;
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
        'marca', 'modelo', 'modelo_descripcion', 'color',
        'recorrido', 'tipo_recorrido', 'currency_id', 'base_rate',
        'precio_final', 'precio_nuevo', 'precio_aprobado', 'precio_nuevo_mod', 'precio_final_mod',
        'estado_avaluo', 'fecha_aprobacion', 'observacion', 'comentario', 'assigned_user_id'];
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
            $query->team_id = 1;
            $query->team_set_id = 1;
        });
    }

    public function imagenes()
    {
        return $this->belongsToMany(
            Imagenes::class,
            'cba_imagenavaluo_cba_avaluos_c',
            'cba_imagenavaluo_cba_avaluoscba_avaluos_ida',
            'cba_imagenavaluo_cba_avaluoscba_imagenavaluo_idb')
            ->where('cba_imagenavaluo.deleted', '0')
            ->select('cba_imagenavaluo.name as id_strapi', 'cba_imagenavaluo.imagen_path');
    }

    public function checklist()
    {
        return $this->belongsToMany(
            CheckList::class,
            'cba_checklist_avaluo_cba_avaluos_c',
            'cba_checklist_avaluo_cba_avaluoscba_avaluos_ida',
            'cba_checklist_avaluo_cba_avaluoscba_checklist_avaluo_idb')
            ->where('cba_checklist_avaluo.deleted', '0')
            ->selectRaw('cba_checklist_avaluo.item_id as id, cba_checklist_avaluo.item_description as description, cba_checklist_avaluo.estado as "option", cba_checklist_avaluo.costo as cost, cba_checklist_avaluo.description as observation');
    }

    public function traffic()
    {
        return $this->belongsToMany(
            Traffic::class,
            'cba_avaluos_cb_traficocontrol_c',
            'cba_avaluos_cb_traficocontrolcba_avaluos_idb',
            'cba_avaluos_cb_traficocontrolcb_traficocontrol_ida');
    }

    public function coordinator()
    {
        return $this->hasOne(Users::class, 'id', 'user')->selectRaw('id,id as code, CONCAT(first_name , " ",last_name) as name');
    }

    public function client()
    {
        return $this->hasOne(Contacts::class, 'id', 'contact')->selectRaw('id,CONCAT(first_name , " ",last_name) as name');
    }

    public function clientCstm()
    {
        return $this->hasOne(ContactsCstm::class, 'id_c', 'contact')->selectRaw('id_c,numero_identificacion_c');
    }

    public function color()
    {
        return $this->hasOne(Colors::class, 'id', 'color')->select('id','name');
    }

    public function brand()
    {
        return $this->hasOne(Brands::class, 'id', 'marca')->select('id','name');
    }

    public function model()
    {
        return $this->hasOne(Models::class, 'id', 'modelo')->select('id','name');
    }

    public function description()
    {
        return $this->hasOne(Descriptions::class, 'id', 'modelo_descripcion')->select('id','description');
    }

    public static function getAvaluo ($id)
    {
        return self::where('id', $id)
            ->with('imagenes')
            ->with('checklist')
            ->with('coordinator')
            ->with('client')
            ->with('clientCstm')
            ->with('color')
            ->with('brand')
            ->with('model')
            ->with('description')
            ->selectRaw('id, name as alias, description, contact_id_c as contact, assigned_user_id as user, placa as plate,color, anio as year,
                         marca, modelo, CONVERT(recorrido,UNSIGNED INTEGER) as mileage, tipo_recorrido as unity,modelo_descripcion,
                         CONVERT(precio_final,UNSIGNED INTEGER) as priceFinal, CONVERT(precio_nuevo,UNSIGNED INTEGER) as priceNew,
                         CONVERT(precio_aprobado,UNSIGNED INTEGER) as priceApproved ,CONVERT(precio_nuevo_mod,UNSIGNED INTEGER) as priceNewEdit,
                         CONVERT(precio_final_mod,UNSIGNED INTEGER) as priceFinalEdit, estado_avaluo as status, fecha_aprobacion as date,
                         observacion as observation, comentario as comment, referido_c as referred')
            ->leftJoin('cba_avaluos_cstm','id','id_c')
            ->where('estado_avaluo','<>',0) // Avaluo cancelado
            ->where('estado_avaluo','<>',4) // Avaluo Vacio eliminado
            ->first();

    }

    public static function getAvaluoByContact ($idContact){
        return self::where('contact_id_c', $idContact)
            ->with('imagenes')
            ->with('checklist')
            ->with('client')
            ->with('clientCstm')
            ->with('coordinator')
            ->with('color')
            ->with('brand')
            ->with('model')
            ->with('description')
            ->selectRaw('id, name as alias, description, contact_id_c as contact, assigned_user_id as user, placa as plate,color, anio as year,
                         marca, modelo, CONVERT(recorrido,UNSIGNED INTEGER) as mileage, tipo_recorrido as unity,modelo_descripcion,
                         CONVERT(precio_final,UNSIGNED INTEGER) as priceFinal, CONVERT(precio_nuevo,UNSIGNED INTEGER) as priceNew,
                         CONVERT(precio_aprobado,UNSIGNED INTEGER) as priceApproved ,CONVERT(precio_nuevo_mod,UNSIGNED INTEGER) as priceNewEdit,
                         CONVERT(precio_final_mod,UNSIGNED INTEGER) as priceFinalEdit, estado_avaluo as status, fecha_aprobacion as date,
                         observacion as observation, comentario as comment, referido_c as referred')
            ->leftJoin('cba_avaluos_cstm','id','id_c')
            ->where('estado_avaluo','<>',5) // Avaluo Vacio
            ->where('estado_avaluo','<>',4) // Avaluo Vacio eliminado
            ->orderBy('date_entered','desc')
            ->get();
    }
}

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
    protected $table = 'cbav_avaluoscrm';
    public $incrementing = false;
    const CREATED_AT = 'date_entered';
    const UPDATED_AT = 'date_modified';
    protected $fillable = ['name',
        'description', 'placa',
        'marca', 'modelo', 'modelo_descripcion', 'color',
        'recorrido', 'tipo_recorrido', 'currency_id', 'base_rate',
        'precio_final', 'precio_nuevo', 'precio_aprobado', 'precio_nuevo_mod', 'precio_final_mod',
        'estado_avaluo', 'fecha_aprobacion', 'observacion', 'comentario', 'assigned_user_id','referido'];
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
            'cbav_imagenesavaluocrm_cbav_avaluoscrm_c',
            'cbav_imagenesavaluocrm_cbav_avaluoscrmcbav_avaluoscrm_ida',
            'cbav_imagenesavaluocrm_cbav_avaluoscrmcbav_imagenesavaluocrm_idb')
            ->where('cbav_imagenesavaluocrm.deleted', '0')
            ->select('cbav_imagenesavaluocrm.name as id_strapi', 'cbav_imagenesavaluocrm.imagen_path');
    }

    public function checklist()
    {
        return $this->belongsToMany(
            CheckList::class,
            'cbav_checklistavaluonew_cbav_avaluoscrm_c',
            'cbav_checklistavaluonew_cbav_avaluoscrmcbav_avaluoscrm_ida',
            'cbav_checkef44aluonew_idb')
            ->where('cbav_checklistavaluonew.deleted', '0')
            ->selectRaw('cbav_checklistavaluonew.item_id as id, cbav_checklistavaluonew.item_description as description, cbav_checklistavaluonew.checklist_estado as "option", cbav_checklistavaluonew.costo as cost, cbav_checklistavaluonew.description as observation');
    }

    public function traffic()
    {
        return $this->belongsToMany(
            Traffic::class,
            'cbav_avaluoscrm_cb_traficocontrol_c',
            'cbav_avaluoscrm_cb_traficocontrolcb_traficocontrol_ida',
            'cbav_avaluoscrm_cb_traficocontrolcbav_avaluoscrm_idb');
    }

    public function talk()
    {
        return $this->belongsToMany(
            Talks::class,
            'cbav_avaluoscrm_cb_negociacion_c',
            'cbav_avaluoscrm_cb_negociacioncb_negociacion_ida',
            'cbav_avaluoscrm_cb_negociacioncbav_avaluoscrm_idb');
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
        return $this->hasOne(ContactsCstm::class, 'id_c', 'contact')->selectRaw('id_c,numero_identificacion_c as document');
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
                         observacion as observation, comentario as comment, referido as referred')
            ->where('estado_avaluo','<>','C') // Avaluo caducado
            ->where('estado_avaluo','<>','X') // Avaluo Vacio eliminado
            ->where('deleted',0)
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
                         observacion as observation, comentario as comment, referido as referred')
            ->where('estado_avaluo','<>','N') // Avaluo Vacio
            ->where('estado_avaluo','<>','X') // Avaluo Vacio eliminado
            ->where('deleted',0)
            ->orderBy('date_entered','desc')
            ->get();
    }
}
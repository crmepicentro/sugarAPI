<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agencies extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'cb_agencias';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'name', 'date_entered', 'date_modified', 'modified_user_id', 'created_by',
        'description', 'deleted', 's3s_id',
        'team_id', 'team_set_id', 'assigned_user_id'
    ];

    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public static function getAll()
    {
        return self::where('deleted', 0)->pluck('name', 'id');
    }

  public static function getAllCodeName()
  {
    return self::select('id as code','name','assigned_user_id')->where('deleted', 0)->orderBy('name')->get();
  }

    public static function getAllCodeNameByLine($line)
    {
        return self::select('cb_agencias.id as code','cb_agencias.name')
            ->join('cb_agencias_cb_lineanegocio_c','cb_agencias.id','=','cb_agencias_cb_lineanegociocb_agencias_ida')
            ->join('cb_lineanegocio', 'cb_lineanegocio.id', '=', 'cb_agencias_cb_lineanegociocb_lineanegocio_idb')
            ->where('cb_lineanegocio.name', $line)
            ->where('cb_agencias.deleted', 0)
            ->where('cb_agencias_cb_lineanegocio_c.deleted', 0)
            ->orderBy('cb_agencias.name')->get();
    }


    public static function getAllCodeNameByUser($idUser)
  {
    return self::select('id as code','name','assigned_user_id')
              ->join('users_cstm','cb_agencias_id_c','cb_agencias.id')
              ->where('users_cstm.id_c',$idUser)
              ->where('cb_agencias.deleted', 0)
              ->orderBy('cb_agencias.name')
              ->get();
  }

    public static function getAllByLineaNegocio($idLinea)
    {
        return self::where('cb_agencias.deleted', 0)
            ->join('cb_agencias_cb_lineanegocio_c', 'cb_agencias.id', '=', 'cb_agencias_cb_lineanegocio_c.cb_agencias_cb_lineanegociocb_agencias_ida')
            ->where('cb_agencias_cb_lineanegocio_c.cb_agencias_cb_lineanegociocb_lineanegocio_idb', $idLinea)
            ->where('cb_agencias_cb_lineanegocio_c.deleted', 0)
            ->pluck('cb_agencias.name', 'cb_agencias.id');
    }

    public static function getForS3SId($idS3S)
    {
        return self::where('s3s_id', $idS3S)->first();
    }
}

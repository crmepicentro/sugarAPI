<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessLine extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cb_lineanegocio';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['name', 'date_entered', 'date_modified', 'modified_user_id', 'created_by', 'description', 'deleted'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function users()
    {
        return $this->belongsToMany(
            Users::class,
            'cb_lineanegocio_users_c',
            'cb_lineanegocio_userscb_lineanegocio_ida',
            'cb_lineanegocio_usersusers_idb');
    }

  public static function getAllByAgency($idBussines)
  {
    return self::select('cb_lineanegocio.id as code','cb_lineanegocio.name as name')
                ->join('cb_agencias_cb_lineanegocio_c', 'cb_lineanegocio.id', '=', 'cb_agencias_cb_lineanegocio_c.cb_agencias_cb_lineanegociocb_lineanegocio_idb')
                ->where('cb_agencias_cb_lineanegocio_c.cb_agencias_cb_lineanegociocb_agencias_ida', $idBussines)
                ->where('cb_agencias_cb_lineanegocio_c.deleted', 0)
                ->where('cb_lineanegocio.deleted', 0)
                ->get();
  }

  public static function getAllCodeNameByAgency($agency)
  {

    return self::select('cb_lineanegocio.id as code','cb_lineanegocio.name as name')
      ->join('cb_agencias_cb_lineanegocio_c', 'cb_lineanegocio.id', '=', 'cb_agencias_cb_lineanegocio_c.cb_agencias_cb_lineanegociocb_lineanegocio_idb')
      ->where('cb_agencias_cb_lineanegocio_c.cb_agencias_cb_lineanegociocb_agencias_ida', $agency)
      ->where('cb_agencias_cb_lineanegocio_c.deleted', 0)
      ->where('cb_lineanegocio.deleted', 0)
      ->get();
  }

  public static function getAllCodeNameByAgencyAndUser($idBussines,$idUser)
  {
    return self::select('cb_lineanegocio.id as code','cb_lineanegocio.name as name')
      ->join('cb_agencias_cb_lineanegocio_c', 'cb_lineanegocio.id', '=', 'cb_agencias_cb_lineanegocio_c.cb_agencias_cb_lineanegociocb_lineanegocio_idb')
      ->join('cb_lineanegocio_users_c', 'cb_lineanegocio.id', '=', 'cb_lineanegocio_users_c.cb_lineanegocio_userscb_lineanegocio_ida')
      ->where('cb_agencias_cb_lineanegocio_c.cb_agencias_cb_lineanegociocb_agencias_ida', $idBussines)
      ->where('cb_lineanegocio_users_c.cb_lineanegocio_usersusers_idb', $idUser)
      ->where('cb_agencias_cb_lineanegocio_c.deleted', 0)
      ->where('cb_lineanegocio.deleted', 0)
      ->get();
  }
}

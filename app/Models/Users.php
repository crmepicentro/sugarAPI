<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'users';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'user_name'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function interacciones()
    {
        return $this->hasMany(Interacciones::class, 'assigned_user_id');
    }

    public function lineas_negocio_user()
    {
        return $this->belongsToMany(
            BusinessLine::class,
            'cb_lineanegocio_users_c',
            'cb_lineanegocio_usersusers_idb',
            'cb_lineanegocio_userscb_lineanegocio_ida');
    }

    public function usersCstm()
    {
        return $this->hasOne(UsersCstm::class, 'id_c', 'id');
    }

    public function meetings()
    {
        return $this->belongsToMany(
            Meetings::class,
            'meetings_users',
            'user_id',
            'meeting_id');
    }

    public function calls()
    {
        return $this->belongsToMany(
            Calls::class,
            'calls_users',
            'user_id',
            'call_id');
    }

    public static function getRandomAsesor($position, $dias, $fuente = 'all')
    {
        return \DB::connection(get_connection())->select('
        SELECT t.usuario as id,t.user_name,t.cuantos
        FROM (SELECT u.id  usuario,u.user_name, countInteraccionesAsigFuente(u.id, '. $dias .', \''. $fuente. '\') cuantos
        FROM users u
        INNER JOIN users_cstm uc ON u.id=uc.id_c
        WHERE u.status=\'Active\' AND u.deleted=0 AND uc.cargo_c=' .$position. ' )  AS t
        ORDER BY t.cuantos,t.user_name  ASC
        limit 1
        ');
    }

    public static function getRandomAsesorByAgency($agency_id, $line_id, $position, $dias, $medio = 'all')
    {
        return \DB::connection(get_connection())->select('
        SELECT t.usuario as id,t.user_name,t.cuantos
        FROM (SELECT u.id  usuario,u.user_name, countInteraccionesAsigMedio(u.id, '. $dias .', \''. $medio. '\') cuantos
        FROM users u
        INNER JOIN users_cstm uc ON u.id=uc.id_c
        INNER JOIN cb_lineanegocio_users_c lu ON u.id=lu.cb_lineanegocio_usersusers_idb
        u.status="Active" AND lu.deleted = 0 AND u.deleted= 0  AND uc.cargo_c= '. $position .' AND uc.cb_agencias_id_c = "'. $agency_id .'"
        AND lu.cb_lineanegocio_userscb_lineanegocio_ida="'. $line_id .'")  AS t
        ORDER BY t.cuantos ASC
        LIMIT 1
        ');
    }

    public static function getRandomAsesorUIO($line_id, $position, $dias, $medio = 'all')
    {
        return \DB::connection(get_connection())->select('
        SELECT t.usuario,t.cuantos FROM (
        SELECT u.id  usuario, countInteraccionesAsigMedio(u.id, '. $dias .', \''. $medio. '\') cuantos FROM users u
        INNER JOIN users_cstm uc ON u.id=uc.id_c
        INNER JOIN cb_lineanegocio_users_c lu ON u.id=lu.cb_lineanegocio_usersusers_idb
        WHERE
        u.status="Active" AND lu.deleted= 0  AND u.deleted= 0 AND uc.cargo_c='. $position .'
        AND lu.cb_lineanegocio_userscb_lineanegocio_ida="'. $line_id .'"
        AND uc.cb_agencias_id_c NOT IN ("8e8f518c-d327-11e9-bdfe-000c297d72b1","1b7640c4-2e36-11ea-8448-000c297d72b1")
         )  AS t
        ORDER BY t.cuantos ASC
        LIMIT 1
        ');
    }

    public static function get_comercial_users($withEmail = true, $withBussinessLine = true, $medio = null)
    {
        $usersBlocked = [];

        if($medio) {
            $usersBlocked = SugarUsersBlocked::where('status', 'inactive')->where('sources_blocked', 'like', '%'.$medio.'%')->pluck('sugar_user_id');
        }

        $users = Users::where('status', 'Active')
           ->where('users.deleted', 0)
           ->whereNotIn('users.id', $usersBlocked)
           ->where('users.deleted', 0)
           ->join('users_cstm', 'users.id', '=', 'users_cstm.id_c')
           ->join('cb_agencias', 'users_cstm.cb_agencias_id_c', '=', 'cb_agencias.id')
           ->where('cargo_c', 2)
           /*->join('email_addr_bean_rel', 'email_addr_bean_rel.bean_id', '=', 'users.id')
           ->join('email_addresses', 'email_addresses.id', '=', 'email_addr_bean_rel.email_address_id')
           ->where('primary_address', 1)*/
           ->with('lineas_negocio_user')
           ->select('users.id', 'first_name', 'last_name', 'phone_mobile', 'user_name', 'cb_agencias.name as agencia')
           ->get();

           if($withBussinessLine || $withEmail){
               foreach ($users as $user){
                   if($withBussinessLine){
                       $user->lineas_negocio = $user->lineas_negocio_user()->where('cb_lineanegocio.deleted', 0)->pluck('name');
                   }

                   if($withEmail) {
                       $emailRel = EmailAddrBeanRel::where('bean_id', $user->id)->where('primary_address', 1)->first();
                       if($emailRel){
                           $userEmail = EmailAddreses::where('id', $emailRel->email_address_id)->first();
                           $user->email = $userEmail->email_address;
                       }
                   }
               }
           }

        return $users;
    }

    public static function get_user($user_name)
    {
       return Users::where('user_name',$user_name)
                      ->where('deleted', 0)
                      ->first();
    }

    public static function getByAgency($idAgencia)
    {
        return self::where('status', 'Active')
            ->where('deleted', 0)
            ->where('cargo_c', 2)
            ->where('cb_agencias_id_c',$idAgencia)
            ->join('users_cstm', 'users.id', '=', 'users_cstm.id_c')
            ->select('id', DB::raw("CONCAT(first_name,' ',last_name) AS name"))
            ->pluck('name', 'id');
    }

    public static function getByAgencyLineaNegocio($idAgencia, $idLinea)
    {
        return self::select('users.id as code', DB::raw("CONCAT(users.first_name,' ',users.last_name) AS name"))
            ->where('status', 'Active')
            ->where('users.deleted', 0)
            ->join('users_cstm', 'users.id', '=', 'users_cstm.id_c')
            ->where('users_cstm.cargo_c', 2)
            ->where('users_cstm.cb_agencias_id_c',$idAgencia)
            ->join('cb_lineanegocio_users_c', 'users.id', '=', 'cb_lineanegocio_users_c.cb_lineanegocio_usersusers_idb')
            ->where('cb_lineanegocio_users_c.cb_lineanegocio_userscb_lineanegocio_ida',$idLinea)
            ->get();
    }

    public static function getRandomAsesorProspectoByAgency($agency_id, $line_id, $position, $dias)
    {
        return \DB::connection(get_connection())->select('
            SELECT t.usuario,t.cuantos FROM (
            SELECT u.id  usuario, countProspectosAsig(u.id,'. $dias .') cuantos FROM users u
            INNER JOIN users_cstm uc ON u.id=uc.id_c
            INNER JOIN cb_lineanegocio_users_c lu ON u.id=lu.cb_lineanegocio_usersusers_idb
            WHERE
            u.status="Active" AND lu.deleted="0" AND u.deleted="0" AND uc.cargo_c="'.$position.'" AND uc.cb_agencias_id_c="'.$agency_id.'"
             AND lu.cb_lineanegocio_userscb_lineanegocio_ida="'.$line_id.'"
             )  AS t

            ORDER BY t.cuantos ASC
            LIMIT  1
        ');
    }
}

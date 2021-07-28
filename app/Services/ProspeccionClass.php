<?php
namespace App\Services;

use App\Models\Prospeccion;
use App\Models\ProspeccionCstm;
use Carbon\Carbon;

class ProspeccionClass {
  /**
   * @param dataProspeccion
   */

  public static function store($dataProspeccion)
  {
    $prospeccion = Prospeccion::getIdentificacionUserStatus($dataProspeccion['numero_identificacion'])->first();
    $new = 0;

    if(!$prospeccion){
      $new = 1;
      $prospeccion = new Prospeccion();
      $prospeccion->date_entered = Carbon::now('UTC');
      $prospeccion->created_by = $dataProspeccion["created_by"];
      $prospeccion->modified_user_id = $dataProspeccion["created_by"];
      $prospeccion->deleted = $dataProspeccion["deleted"] ?? 0;
      $prospeccion->team_id = $dataProspeccion["team_id"];
      $prospeccion->team_set_id = $dataProspeccion["team_set_id"];

      $autoincrement = Prospeccion::count();
      $prospeccion->name = env('PROSPECCION_PREFIX', "PROSPECTO-").intval($autoincrement + 1);
      $prospeccion->brinda_identificacion = $dataProspeccion["brinda_identificacion"];
      $prospeccion->tipo_identificacion = $dataProspeccion['tipo_identificacion'];
      $prospeccion->numero_identificacion = $dataProspeccion['numero_identificacion'];
      $prospeccion->save();
    }

    $dataProspeccion['prospeccion_id'] = $prospeccion->id;
    self::storeCstm($dataProspeccion);

    if($dataProspeccion['concat_description']){
      $prospeccion->description = trim($prospeccion->description . " " . $dataProspeccion['description']);
    }else{
      $prospeccion->description = $dataProspeccion['description'];
    }

    $prospeccion->fuente = $dataProspeccion['fuente'];
    $prospeccion->estado = $dataProspeccion["estado"];
    $prospeccion->nombres = $dataProspeccion['names'];
    $prospeccion->apellidos = $dataProspeccion['surnames'];
    $prospeccion->celular = $dataProspeccion['cellphone_number'];
    $prospeccion->telefono = $dataProspeccion['phone_home'] ?? null;
    $prospeccion->email = $dataProspeccion['email'];
    $prospeccion->campaign_id_c = $dataProspeccion['campaign_id_c'] ?? null;
    $prospeccion->cb_lineanegocio_id_c = $dataProspeccion['cb_lineanegocio_id_c'];
    $prospeccion->date_modified = Carbon::now('UTC');
    $prospeccion->assigned_user_id = $dataProspeccion['assigned_user_id'];
    $prospeccion->save();
    $prospeccion->new = $new;
    return $prospeccion;
  }

  private static function storeCstm($dataProspeccion)
  {
    $prospeccionCstm = ProspeccionCstm::where('id_c', $dataProspeccion['prospeccion_id'])->first();

    if(!$prospeccionCstm){
      $prospeccionCstm = new ProspeccionCstm();
      $prospeccionCstm->id_c = $dataProspeccion['prospeccion_id'];
      $prospeccionCstm->fecha_primera_modificacion_c = Carbon::now('UTC');
      $prospeccionCstm->user_id_c = $dataProspeccion["assigned_user_id"];
    }

    $prospeccionCstm->modelo_c = $dataProspeccion['modelo_c'] ?? null;
    $prospeccionCstm->medio_c = $dataProspeccion['medio'];
    $prospeccionCstm->save();
  }
}



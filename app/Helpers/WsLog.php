<?php
// Copyright (C) 2021 Casabaca. Todos los derechos reservados.
// Publicado bajo las condiciones de Licencia de Software Propietario.
namespace App\Helpers;

use App\Models\Ws_logs;

class  WsLog {

  public static function storeBefore($data, $route){
    $ws_logs = new Ws_logs();
    $ws_logs->route = $route;
    $ws_logs->datos_sugar_crm = json_encode($data["datosSugarCRM"]);
    $ws_logs->datos_adicionales = json_encode($data["datos_adicionales"]);
    $ws_logs->save();
    return $ws_logs;
  }

  public static function storeAfter($ws_logs, $data){
    $ws_logs->response = $data["response"];
    $ws_logs->ticket_id = $data["ticket_id"] ?? null;
    $ws_logs->environment = $data["environment"];
    $ws_logs->source = $data["source"];
    $ws_logs->interaccion_id = $data["interaccion_id"] ?? null;
    $ws_logs->prospeccion_id = $data["prospeccion_id"] ?? null;
    $ws_logs->call_id = $data["call_id"] ?? null;
    $ws_logs->meeting_id = $data["meeting_id"] ?? null;
    $ws_logs->save();
  }

}

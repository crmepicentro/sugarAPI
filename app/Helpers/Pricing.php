<?php
// Copyright (C) 2021 Casabaca. Todos los derechos reservados.
// Publicado bajo las condiciones de Licencia de Software Propietario.
namespace App\Helpers;

use App\Models\Ws_logs;
use Illuminate\Support\Facades\Http;

class  Pricing {

  public static function getToken(){
      $response = Http::post(env('PRICING').'authentication',['user' => env('USER_PRICING'),'password' => env('PASSWORD_PRICING')]);
      dd($response);
    return true;
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

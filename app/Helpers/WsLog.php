<?php
// Copyright (C) 2021 Casabaca. Todos los derechos reservados.
// Publicado bajo las condiciones de Licencia de Software Propietario.
namespace App\Helpers;

use App\Models\Ws_logs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class  WsLog
{

    public static function storeBefore($data, $route)
    {
        $ws_logs = new Ws_logs();
        $ws_logs->route = $route;
        $ws_logs->datos_sugar_crm = json_encode($data["datosSugarCRM"]);
        $ws_logs->datos_adicionales = json_encode($data["datos_adicionales"]);
        $ws_logs->save();
        return $ws_logs;
    }

    public static function storeAfter($ws_logs, $data)
    {
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


    public static function getErrorlogs()
    {
        return DB::table('ws_logs')->select('id', 'route', 'datos_sugar_crm', 'datos_adicionales', 'response')->where('response', 'like', '%Undefined%')->get();
    }

    public static function getDuplicadoLog($request)
    {
    $cadena_principal = json_encode($request->datosSugarCRM);
    $cadena_adicional = $request->datos_adicionales;
    //la cadena no es igual porque agregue un campo reproceso hay que eliminar el campo reproceso para comparar con el log
    if($cadena_adicional){
      $cadena_adicional = json_encode($request->datos_adicionales);
      return DB::table('ws_logs')->select('id','route','datos_sugar_crm','datos_adicionales','response','source')
                                ->where('datos_sugar_crm','=', $cadena_principal)
                                ->where('datos_adicionales','=', $cadena_adicional)->first();
    }else{

      return DB::table('ws_logs')->select('id','route','datos_sugar_crm','datos_adicionales','response','source')
                                ->where('datos_sugar_crm','=', $cadena_principal)->first();
    }

  }

  public static function updateResponse($id,$response){
    return DB::table('ws_logs')->where('id', $id)
                              ->update(['response' => $response]);
  }
    public static function deleteWpLogId($id){
        DB::table('ws_logs')->delete($id);

    }
}

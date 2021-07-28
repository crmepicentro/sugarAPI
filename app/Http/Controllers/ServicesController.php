<?php

namespace App\Http\Controllers;

use App\Helpers\Contacts;
use App\Http\Requests\ServicesDocumentRequest;
use App\Models\BusinessLine;
use App\Models\Users;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicesController extends Controller
{
    public function getDocument(ServicesDocumentRequest $request)
    {
      try{
        $data = Contacts::getData($request->get('document'),mb_strtoupper($request->get('type')));
        return response()->json($data, Response::HTTP_OK);
      }catch (\Exception $e) {
        return response()->json(['error' => '!Error¡ Notifique a SUGAR CRM Casabaca', 'msg' => $e->getMessage() . '- Line: ' . $e->getLine() . '- Archivo: ' . $e->getFile()], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }

  public function getAdvisers(Request $request)
  {
    try{
      $data = Users::getByAgencyLineaNegocio($request->get('agency'),$request->get('bussiness'));
      return response()->json($data, Response::HTTP_OK);
    }catch (\Exception $e){
      return response()->json(['error' => '!Error¡ Notifique a SUGAR CRM Casabaca','msg' => $e->getMessage() . '- Line: '.$e->getLine(). '- Archivo: '.$e->getFile()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function getBussiness(Request $request)
  {
    try{
      $data = BusinessLine::getAllByAgency($request->get('agency'));
      return response()->json($data, Response::HTTP_OK);
    }catch (\Exception $e){
      return response()->json(['error' => '!Error¡ Notifique a SUGAR CRM Casabaca','msg' => $e->getMessage() . '- Line: '.$e->getLine(). '- Archivo: '.$e->getFile()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}

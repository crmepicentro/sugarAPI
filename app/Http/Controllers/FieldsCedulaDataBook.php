<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\PayUService\Exception;
use App\Helpers\WsLog;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;


class FieldsCedulaDataBook extends Controller
{
    public function dataBook(Request $request){

        $cedula = $request->DatosDataBook['cedula'];
        $tipo_identificacion = $request->DatosDataBook['tipo_identificacion'];
        $compania = $request->DatosDataBook['compania'];

        $resDataBook = $this->getfieldCedulaDataBook($cedula,$tipo_identificacion,$compania);
        $res = json_decode($resDataBook, true);
        return response()->json(["data"=>$res],200);

    }

    public function getfieldCedulaDataBook($cedula,$tipo_identificacion,$compania){
        return $response = Http::get(env("S3S").env("DATABOOKCONSULTARDATOS")."?compania=".$compania."&identificacion=".$cedula."&tipoConsulta=TIT&tipoIdentificacion=".$tipo_identificacion);
    }
}

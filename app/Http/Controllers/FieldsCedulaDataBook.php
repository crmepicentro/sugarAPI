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

        $idCotizacion = $request->DatosDataBook['idCotizacion'];
        //$tipo_identificacion = $request->DatosDataBook['tipo_identificacion'];
        $compania = $request->DatosDataBook['compania'];
        $cedula = "1710295377";
        $tipo_identificacion="C";
        
        $resDataBook = $this->getfieldCedulaDataBook($cedula,$tipo_identificacion,$compania);
        $res = json_decode($resDataBook, true);
        //return response()->json(["data"=>$res],200);

        $datoGenerales = Array(
            "Producto"=>"NEW FORTUNER AC 2.7 5P 4X4 TM",
            "idCotizacion"=>$idCotizacion,
            "ValorProducto"=>"53,999",
            "Entrada"=>"13,500",
            "ValorFinanciar"=>"40,499",
            "Plazo"=>"48",
            "FechaSolicitud"=>"23/03/2022",
            "Asesor"=>"DL_PENALOZA",
            "Agencia"=>"SANTO DOMINGO",
            
        );


        $datosPersonales = Array(
            "Identificador"=>$res['numeroIdentificacion'],
            "Nombres"=>$res['nombres'],
            "Apellidos"=>$res['apellidos'],
            "Sexo"=>$res['genero'],
            "FechaNacimiento"=>"1987-01-18",
            "Nacionalidad"=>"Ecuatoriana",
            "EstadoCivil"=>"Casado",
        );

        $datosDomicilio = Array(
            "Provincia"=>"Pichincha",
            "Ciudad"=>"Quito",
            "CallePrincipal"=>"Granados",
            "NumeroCasa"=>"E9-31",
            "CalleSecundaria"=>"",
            "Referencias"=>"Redondel del ciclista",
            "TelfCasa"=>"098765432",
            "TelfCelular"=>"0987654321",
            "CorreoElectronico"=>"cliente@casabaca.com",
        );

        $relacionDependencia = Array(
            
            "Ruc"=>"1790009459001",
            "NombreEmpleador"=>"Casabaca S.A.",
            "DireccionEmpleador"=>"10 de Agosto N21-281 Carrion",
            "TelefonoEmpleador"=>"022606254",
            "ActividadEmpleador"=>"Comercio exterior importaciones y exportaciones de CASABACA S.A.",
            "Cargo"=>"Cargo en el que se desempeña",
            "TiempoTrabajo"=>"20"
        );

        $dataBook = array(
            "datosGenerales"=> $datoGenerales,
            "datosPersonales"=>$datosPersonales,
            "datosDomicilio"=>$datosDomicilio,
            "datosTrabajo"=>$relacionDependencia
        );

        return response()->json(["databook"=>$dataBook],200);

    }

    public function getfieldCedulaDataBook($cedula,$tipo_identificacion,$compania){
        return $response = Http::get(env("S3S").env("DATABOOKCONSULTARDATOS")."?compania=".$compania."&identificacion=".$cedula."&tipoConsulta=TIT&tipoIdentificacion=".$tipo_identificacion);
    }
}

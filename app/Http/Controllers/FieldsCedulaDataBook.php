<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\PayUService\Exception;
use App\Helpers\WsLog;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;

use App\Models\OpportunitiesCstm; 
use App\Models\Opportunities; 
use App\Models\EmailAddrBeanRel;
use App\Models\EmailAddreses;
use App\Models\Users;
use App\Models\Nationality;
use App\Models\Agencies;


class FieldsCedulaDataBook extends Controller
{
    public function dataBook(Request $request){

        try {
            $idCotizacion = $request->CreditoDataBook['idCotizacion']; 
            $compania = $request->CreditoDataBook['compania'];
            $opportunities = OpportunitiesCstm::opportunitiesCstmContacts($idCotizacion);

            $emails = EmailAddrBeanRel::where('bean_id', $opportunities->id)
                                        ->where('primary_address', 1)
                                        ->where('deleted', 0)->pluck('email_address_id');
            $email= EmailAddreses::whereIn('id', $emails) ->where('deleted', 0)->select('email_address')->first();
            $nacionality = Nationality::find($opportunities['nacionalidad_c']);
            
            $genero = Array(
                "id"=>$opportunities['genero_c'],
                "nombre"=>getGenero($opportunities['genero_c'])
            );

            $estadoCivil = array(
                "id"=>$opportunities['estado_civil_c'],
                "nombre"=>getEstadoCivil($opportunities['estado_civil_c'])
            );

            $tipoCliente = Array(
                "id"=>$opportunities['tipo_cliente_c'],
                "nombre"=>getTipoCliente($opportunities['tipo_cliente_c'])
            );

            $tipoIdentificacion = Array(
                "id"=>$opportunities['tipo_identificacion_c'],
                "nombre"=>getTipoIdentificacion($opportunities['tipo_identificacion_c'])
            );

            $agencia = Agencies::where('id', $opportunities['cb_agencias_id_c'])->select('id','name')->first();
           
            //return response()->json(["databook"=>$opportunities],200);

             //$resDataBook = $this->getfieldCedulaDataBook($opportunities->numero_identificacion_c,$opportunities->tipo_identificacion_c,$compania);
             //$resData = json_decode($resDataBook, true);
             //return response()->json(["data"=>$resData],200);

             $datoGenerales = Array(
                "Tipo_cliente"=> $tipoCliente,
                "tipoIdentificador"=>$tipoIdentificacion,
                "Identificador"=>$opportunities['numero_identificacion_c'],
                "Nombres"=>$opportunities['first_name'],
                "Apellidos"=>$opportunities['last_name'],
                "Sexo"=>$genero,
                "FechaNacimiento"=>$opportunities['birthdate'],
                "Nacionalidad"=>$nacionality,
                "EstadoCivil"=>$estadoCivil,
                
                //"Provincia_casa"=>$opportunities['provincia_c'],
                //"Parroquia_casa"=>$opportunities['parroquia_c'],
                //"Ciudad_casa"=>$opportunities['ciudad_c'],
                "Sector_casa"=>$opportunities['sector_c'],
                "CallePrincipal_casa"=>$opportunities['calle_principal_c'],
                "NumeroCasa"=>$opportunities['no_casa_c'],
                "CalleSecundaria_casa"=>$opportunities['calle_principal_c'],
                "Referencias_casa"=>$opportunities['referencia_c'],
                "TelfCasa"=>$opportunities['phone_home'],
                "TelfCelular"=>$opportunities['phone_mobile'],
                "CorreoElectronico"=>$email->email_address
            );

            $datosAdicionales = Array(
                "Ruc_trabajo"=>"1790009459001",
                "NombreEmpleador_trabajo"=>"Casabaca S.A.",
                "DireccionEmpleador_trabajo"=>"10 de Agosto N21-281 Carrion",
                "TelefonoEmpleador_trabajo"=>$opportunities['phone_work'],
                "ActividadEmpleador_trabajo"=>"Comercio exterior importaciones y exportaciones de CASABACA S.A.",
                "Cargo_trabajo"=>"Cargo en el que se desempeña",
                "TiempoAnios_trabajo"=>"20",
            );

            $datosCotizacion =Array(
                "Producto"=>$opportunities['modelo_c'],
                "idCotizacion"=>$idCotizacion,
                "Cotizacion"=>$opportunities['id_cotizacion_c'],
                "TipoFimanciamiento"=>$opportunities['tipofinanciamientotext_c'],
                "TipoFimanciera"=>$opportunities['tipofinancieratext_c'],
                "ValorProducto"=>$opportunities['amount'],
                "Entrada"=>$opportunities['valorentrada_c'],
                "ValorFinanciar"=>$opportunities['saldoafinanciar_c'],
                "Plazo"=>$opportunities['plazo_c'],
                "FechaSolicitud"=>$opportunities['fecha_cotizacion_c'],
                "Asesor"=>$opportunities['username_c'],
                "NombreAsesor"=>$opportunities['nombres_apellidos_c'],
                "Agencia"=>$agencia, 
            );

            $data = Array(
                "DatosCotizacion"=> $datosCotizacion,
                "DatosGenerales"=>$datoGenerales,
                "DatosAdicionales"=>$datosAdicionales,
            );
    
            return response()->json(["data"=>$data],200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }  

    }

    public function getfieldCedulaDataBook($cedula,$tipo_identificacion,$compania){
        return $response = Http::get(env("S3S").env("DATABOOKCONSULTARDATOS")."?compania=".$compania."&identificacion=".$cedula."&tipoConsulta=TIT&tipoIdentificacion=".$tipo_identificacion);
    }
}

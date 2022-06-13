<?php

namespace App\Http\Controllers\SolicitudCredito;

use App\Http\Controllers\Controller;
use App\Models\SolicitudCredito\ClienteEmpresa;
use App\Models\SolicitudCredito\ClientePatrimonio;
use App\Models\SolicitudCredito\ClienteReferencia;
use App\Models\SolicitudCredito\SolicitudArchivo;
use App\Models\SolicitudCredito\SolicitudCliente;
use App\Models\SolicitudCredito\SolicitudCredito;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class PersonaNaturalController extends Controller
{

    public function create(Request $request)
    {
        $compania = $request->query("compania");
        $tipoPersona = $request->query("persona");
        // return response()->json(["success" => $compania], 200);
        try {
            //solicitudCredito
            $solicitud = $this->fillSolicitud($request);
            $solicitud->save();
        //empresa
            $empresa = $this->fillEmpresa($request);
            $empresa_id = $empresa->save();
        //referencia
            $referencia = $this->fillReferencia($request);
            $referencias_id = $referencia->save();
        //cliente
            $cliente = $this->fillCliente($request);
            $cliente->empresa_id = $empresa_id;
            $cliente->referencias_id = $referencias_id;
            $cliente->save();
            // patrimonio
            if ($request->patrimonios != null) {
                foreach ($request->patrimonios as $key => $value) {
                    $patrimonio = $this->fillPatrimonio($value);
                    $patrimonio->cliente_id = $cliente->id_cotizacion;
                    $patrimonio->save();
                }
            }
            return response()->json([
                "success" => "Guardado exitoso",
                "dowmload" => route("dowmload.solicitud.credito",[$compania, $tipoPersona, $solicitud->id_cotizacion])
            ], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e . " - Notifique a SUGAR CRM"], 500);
        }
    }

    public function pdf(Request $request)
    {
        $compania = $request->compania;
        $persona = $request->persona;
        if ($compania=="01" && $persona=="01") {
            $pdf = PDF::loadView("solicitud.cbNatural");
        }
        if ($compania=="01" && $persona=="02") {
            $pdf = PDF::loadView("solicitud.cbJuridico");
        }
        // if ($compania=="02" && $persona=="01") {
        //     $pdf = PDF::loadView("solicitud.milNatural");
        // }
        // if ($compania=="02" && $persona=="02") {
        //     $pdf = PDF::loadView("solicitud.milJuridica");
        // }
        return $pdf->stream("solicitud.pdf");
    }

    // valiadar
    public function uploadFile(Request $request)
    {
        $idCotizacion = $request->query("idCotizacion");
        $tipo = $request->query("tipo");
        $path = "solicitudes-credito/solicitud-".$idCotizacion;
        try {
            $file = $request->file("file");
            $nombre = strtolower(str_replace(' ','_', $tipo));
            $extencion = $file->getClientOriginalExtension();
            $fileName = $nombre.".".$extencion;
            $file->storeAs($path, $fileName);
            SolicitudArchivo::updateOrCreate(
                [
                    "id_solicitud" => $idCotizacion,
                    "nombre" => $fileName,
                    "borrado" => 1
                ],
                [
                    "id_solicitud" => $idCotizacion,
                    "nombre" => $fileName,
                    "borrado" => 0
                    ]
                );
            return response()->json(["success" => "Archivo subido"], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e . " - Notifique a SUGAR CRM Casabaca"], 500);
        }
    }

    // crear la ruta y validar
    public function deleteFile(Request $request)
    {
        $idCotizacion = $request->idCotizacion;
        $nombre = $request->nombre;
        $path = "solicitudes-credito/solicitud-".$idCotizacion."/".$nombre;
        try {
            Storage::delete($path);
            SolicitudArchivo::where("id_solicitud", $idCotizacion)
                                ->where("nombre", $nombre)
                                ->update([ "borrado" => true ]);
            return response()->json([ "success" => "Archivo subido" ], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e . " - Notifique a SUGAR CRM Casabaca"], 500);
        }
    }

    public function showFiles(Request $request)
    {
        $data = [];
        $idCotizacion = $request->idCotizacion;
        $files = SolicitudArchivo::where("id_solicitud", $idCotizacion)
                                    ->where("borrado", false)->get();
        foreach ($files as $file) {
            list($nombre, $extension) = explode(".", $file->nombre);
            $data[] = [
                "nombre" => $file->nombre,
                "tipo" => $nombre,
                "extension" => $extension,
                "url" => route("file.solicitud.credito",[$file->id_solicitud, $file->nombre])
            ];
        }
        return response()->json([ "files" => $data ], 200);
    }

    private function fillSolicitud(Request $request)
    {
        $res = $request->solicitudCredito;
        $solicitud = new SolicitudCredito();
        $solicitud->id_cotizacion = $res["idCotizacion"];
        $solicitud->producto = $res["producto"];
        $solicitud->valor_producto = floatval($res["valorProducto"]);
        $solicitud->entrada = floatval($res["entrada"]);
        $solicitud->valor_financiar = floatval($res["valoFinanciar"]);
        $solicitud->plazo = intval($res["plazo"]);
        $solicitud->fecha_solicitud = Carbon::parse($res["fechaSolicitud"]);
        $solicitud->asesor = $res["asesor"];
        $solicitud->agencia = $res["agencia"];
        $solicitud->cedula_cliente = $request->cliente["cedula"];
        return $solicitud;
    }

    private function fillReferencia(Request $request)
    {
        $res = $request->referencia;
        $referencia = new ClienteReferencia();
        $referencia->institucion_1 = $res["institucion1"];
        $referencia->cuenta_tipo_1 = $res["cuentaTipo1"];
        $referencia->no_cuenta_1 = $res["noCuenta1"];
        $referencia->tarjeta_tipo_1 = $res["tarjetaTipo1"];
        $referencia->banco_emisor_1 = $res["bancoEmisor1"];
        $referencia->institucion_2 = $res["institucion2"];
        $referencia->cuenta_tipo_2 = $res["cuentaTipo2"];
        $referencia->no_cuenta_2 = $res["noCuenta2"];
        $referencia->tarjeta_tipo_2 = $res["tarjetaTipo2"];
        $referencia->banco_emisor_2 = $res["bancoEmisor2"];
        $referencia->nombre_completo_1 = $res["nombreCompleto1"];
        $referencia->relacion_cliente_1 = $res["relacionCliente1"];
        $referencia->ciudad_1 = $res["ciudad1"];
        $referencia->telefono_1 = $res["telefono1"];
        $referencia->nombre_completo_2 = $res["nombreCompleto2"];
        $referencia->relacion_cliente_2 = $res["relacionCliente2"];
        $referencia->ciudad_2 = $res["ciudad2"];
        $referencia->telefono_2 = $res["telefono2"];
        $referencia->nombre_completo_3 = $res["nombreCompleto3"];
        $referencia->relacion_cliente_3 = $res["relacionCliente3"];
        $referencia->ciudad_3 = $res["ciudad3"];
        $referencia->telefono_3 = $res["telefono3"];
        $referencia->empresa_nombre_1 = $res["empresaNombre1"];
        $referencia->empresa_ciudad_1 = $res["empresaCiudad1"];
        $referencia->empresa_telefono_1 = $res["empresaTelefono1"];
        $referencia->empresa_nombre_2 = $res["empresaNombre2"];
        $referencia->empresa_ciudad_2 = $res["empresaCiudad2"];
        $referencia->empresa_telefono_2 = $res["empresaTelefono2"];
        return $referencia;
    }

    private function fillEmpresa(Request $request)
    {
        $res = $request->empresa;
        $empresa = new ClienteEmpresa();
        $empresa->nombre = $res["nombre"];
        $empresa->situacion_laboral = $res["situacionLaboral"];
        $empresa->actividad = $res["actividad"];
        $empresa->cargo = $res["cargo"];
        $empresa->direccion = $res["direccion"];
        $empresa->tiempo_trabajo = $res["tiempoTrabajo"];
        $empresa->ext_telefono = $res["extTelefono"];
        $empresa->cyg_nombre = $res["cygNombre"];
        $empresa->cyg_situacion_laboral = $res["cygSituacionLaboral"];
        $empresa->cyg_actividad = $res["cygActividad"];
        $empresa->cyg_cargo = $res["cygCargo"];
        $empresa->cyg_direccion = $res["cygDireccion"];
        $empresa->cyg_tiempo_trabajo = $res["cygTiempoTrabajo"];
        $empresa->cyg_telefono = $res["cygTelefono"];
        $empresa->cyg_ext_telefono = $res["cygExtTelefono"];
        $empresa->telefono = $res["telefono"];
        return $empresa;
    }

    public function fillPatrimonio($value)
    {
        $patrimonio = new ClientePatrimonio();
        $patrimonio->bien_inmueble = $value["bienInmueble"];
        $patrimonio->ciudad_direccion = $value["ciudadDireccion"];
        $patrimonio->hipotecado = $value["hipotecado"];
        $patrimonio->marca_vehiculo = $value["marcaVehiculo"];
        $patrimonio->modelo_vehiculo = $value["modeloVehiculo"];
        $patrimonio->anio = intval($value["anio"]);
        $patrimonio->prendado = $value["prendado"];
        $patrimonio->valor_comercial = floatval($value["valorComercial"]);
        $patrimonio->patrimonio_tipo = $value["tipo"];
        return $patrimonio;
    }

    private function fillCliente(Request $request)
    {
        $res = $request->cliente;
        $cliente = new SolicitudCliente();
        $cliente->nombre_completo = $res["nombreCompleto"];
        $cliente->cedula = $res["cedula"];
        $cliente->pasaporte = $res["pasaporte"];
        $cliente->ruc = $res["ruc"];
        $cliente->estado_civil = $res["estadoCivil"];
        $cliente->separacion_bienes = $res["separacionBienes"];
        $cliente->carga_familiar = $res["cargaFamiliar"];
        $cliente->cyg_nombre_completo = $res["cygNombreCompleto"];
        $cliente->cyg_cedula = $res["cygCedula"];
        $cliente->provincia = $res["provincia"];
        $cliente->ciudad = $res["ciudad"];
        $cliente->calle_principal = $res["callePrincipal"];
        $cliente->calle_secundaria = $res["calleSecundaria"];
        $cliente->no_casa = $res["noCasa"];
        $cliente->sector = $res["sector"];
        $cliente->telefono = $res["telefono"];
        $cliente->celular = $res["celular"];
        $cliente->correo = $res["correo"];
        $cliente->casa_tipo = $res["casaTipo"];
        $cliente->tiempo_residencia = $res["tiempoResidencia"];
        $cliente->sueldo_ventas = $res["sueldoVentas"];
        $cliente->otros_ingresos = $res["otrosIngresos"];
        $cliente->ingreso_total = $res["ingresoTotal"];
        $cliente->cyg_sueldo = $res["cygSueldo"];
        $cliente->ingreso_familiar = $res["ingresoFamiliar"];
        $cliente->descripcion_otros_ingresos = $res["descripcionOtrosIngresos"];
        $cliente->alimentacion = $res["alimentacion"];
        $cliente->arriendo_vivienda = $res["arriendoVivienda"];
        $cliente->entidades_bancarias = $res["entidadesBancarias"];
        $cliente->otros_gastos = $res["otrosGastos"];
        $cliente->gastos_total = $res["gastosTotal"];
        $cliente->persona_tipo = $res["personaTipo"];
        return $cliente;
    }

}

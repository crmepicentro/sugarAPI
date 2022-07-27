<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\SolicitudCredito\ClienteEmpresa;
use App\Models\SolicitudCredito\ClientePatrimonio;
use App\Models\SolicitudCredito\ClienteReferencia;
use App\Models\SolicitudCredito\SolicitudArchivo;
use App\Models\SolicitudCredito\SolicitudCliente;
use App\Models\SolicitudCredito\SolicitudCredito;
use Carbon\Carbon;
use PDF;

class SolicitudCreditoController extends Controller
{
    public function create(Request $request)
    {
        $compania = $request->query("compania");
        $tipoPersona = $request->query("persona");
        // return response()->json(["success" => $compania], 200);
        // try {
        //     DB::connection(get_connection())->beginTransaction();
        //     //solicitudCredito
        //     $solicitud = $this->fillSolicitud($request);
        //     $solicitud->save();
        //     if ($tipoPersona == '01') {
        //         //empresa
        //         $empresa = $this->fillEmpresaNatural($request);
        //         $empresa->save();
        //         //referencia
        //         $referencia = $this->fillReferenciaNatural($request);
        //         $referencia->save();
        //         //clienteN
        //         $cliente = $this->fillClienteNatural($request);
        //         $cliente->empresa_id = $empresa->id;
        //         $cliente->referencias_id = $referencia->id;
        //         $cliente->save();
        //     }
        //     if ($tipoPersona == '02') {
        //         //empresa
        //         $empresa = $this->fillEmpresaJuridica($request);
        //         $empresa->save();
        //         //referencia
        //         $referencia = $this->fillReferenciaJuridica($request);
        //         $referencia->save();
        //         //cliente
        //         $cliente = $this->fillClienteJuridica($request);
        //         $cliente->empresa_id = $empresa->id;
        //         $cliente->referencias_id = $referencia->id;
        //         $cliente->save();
        //     }
        //     // patrimonio
        //     if ($request->patrimonios != null) {
        //         foreach ($request->patrimonios as $key => $value) {
        //             $patrimonio = $this->fillPatrimonio($value);
        //             $patrimonio->cliente_id = $cliente->id_cotizacion;
        //             $patrimonio->save();
        //         }
        //     }
        //     DB::connection(get_connection())->commit();
        //     return response()->json([
        //         "success" => "Guardado exitoso",
        //         "dowmload" => route("solicitud.file", [strval($solicitud->id_cotizacion), strval($compania), strval($tipoPersona)])
        //     ], 200);
        // } catch (\Exception $e) {
        //     DB::connection(get_connection())->rollBack();
        //     return response()->json(["error" => $e . " - Notifique a SUGAR CRM"], 500);
        // }
        try {
            $res = $this->conexionProveedor();
            return response()->json([
                "success" => $res
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function pdf(Request $request)
    {
        $compania = $request->compania;
        $persona = $request->persona;
        $solicitud = $request->solicitud;
        if ($compania=="3" && $persona=="01") {
            $pdf = PDF::loadView("solicitud.cbNatural");
        }
        if ($compania=="3" && $persona=="02") {
            $pdf = PDF::loadView("solicitud.cbJuridico");
        }
        if ($compania=="6" && $persona=="01") {
            $pdf = PDF::loadView("solicitud.milNatural");
        }
        if ($compania=="6" && $persona=="02") {
            $pdf = PDF::loadView("solicitud.milJuridica");
        }
        return $pdf->stream("solicitud-{$solicitud}.pdf");
    }

    public function pdfView()
    {
        $pdf = PDF::loadView("solicitud.cbNatural");
        $pdf = PDF::loadView("solicitud.cbJuridico");
        // $pdf = PDF::loadView("solicitud.milNatural");
        // $pdf = PDF::loadView("solicitud.milJuridica");
    }
    public function uploadFile(Request $request)
    {
        $idCotizacion = $request->query("idCotizacion");
        $tipo = $request->query("tipo");
        $path = "solicitudes-credito/solicitud-".$idCotizacion;
        try {
            DB::connection(get_connection())->beginTransaction();
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
            DB::connection(get_connection())->commit();
            return response()->json(["success" => "Archivo subido"], 200);
        } catch (\Exception $e) {
            DB::connection(get_connection())->rollBack();
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
            DB::connection(get_connection())->beginTransaction();
            Storage::delete($path);
            SolicitudArchivo::where("id_solicitud", $idCotizacion)
                                ->where("nombre", $nombre)
                                ->update([ "borrado" => true ]);
            DB::connection(get_connection())->commit();
            return response()->json([ "success" => "Archivo eliminado" ], 200);
        } catch (\Exception $e) {
            DB::connection(get_connection())->rollBack();
            return response()->json(["error" => $e . " - Notifique a SUGAR CRM Casabaca"], 500);
        }
    }

    public function showFiles(Request $request)
    {
        DB::connection(get_connection())->beginTransaction();
        $data = [];
        $idCotizacion = $request->idCotizacion;
        $files = SolicitudArchivo::where("id_solicitud", $idCotizacion)
                                    ->where("borrado", false)->get();
        DB::connection(get_connection())->commit();
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
        $solicitud->valor_financiar = floatval($res["valorFinanciar"]);
        $solicitud->plazo = intval($res["plazo"]);
        $solicitud->fecha_solicitud = $res["fechaSolicitud"] != null ? Carbon::parse($res["fechaSolicitud"]) : $res["fechaSolicitud"];
        $solicitud->asesor = $res["asesor"];
        $solicitud->agencia = $res["agencia"];
        $solicitud->cedula_cliente = $request->cliente["cedula"];
        $solicitud->financiamiento = $res["financiamiento"];
        return $solicitud;
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
    private function fillReferenciaNatural(Request $request)
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
    private function fillReferenciaJuridica(Request $request)
    {
        $res = $request->referencia;
        $referencia = new ClienteReferencia();
        $referencia->institucion_1 = $res['institucion1'];
        $referencia->cuenta_tipo_1 = $res['cuentaTipo1'];
        $referencia->no_cuenta_1 = $res['noCuenta1'];
        $referencia->tarjeta_tipo_1 = $res['tarjetaTipo1'];
        $referencia->banco_emisor_1 = $res['bancoEmisor1'];
        $referencia->institucion_2 = $res['institucion2'];
        $referencia->cuenta_tipo_2 = $res['cuentaTipo2'];
        $referencia->no_cuenta_2 = $res['noCuenta2'];
        $referencia->tarjeta_tipo_2 = $res['tarjetaTipo2'];
        $referencia->banco_emisor_2 = $res['bancoEmisor2'];
        $referencia->empresa_nombre_1 = $res['empresaNombre1'];
        $referencia->empresa_ciudad_1 = $res['empresaCiudad1'];
        $referencia->empresa_telefono_1 = $res['empresaTelefono1'];
        $referencia->empresa_nombre_2 = $res['empresaNombre2'];
        $referencia->empresa_ciudad_2 = $res['empresaCiudad2'];
        $referencia->empresa_telefono_2 = $res['empresaTelefono2'];
        $referencia->empresa_nombre_3 = $res['empresaNombre3'];
        $referencia->empresa_ciudad_3 = $res['empresaCiudad3'];
        $referencia->empresa_telefono_3 = $res['empresaTelefono3'];
        $referencia->compra_nombre_completo = $res['compraNombreCompleto'];
        $referencia->compra_correo = $res['compraCorreo'];
        $referencia->compra_celular = $res['compraCelular'];
        $referencia->compra_telefono = $res['compraTelefono'];
        $referencia->compra_ext_telefono = $res['compraExtTelefono'];
        $referencia->pago_nombre_completo = $res['pagoNombreCompleto'];
        $referencia->pago_correo = $res['pagoCorreo'];
        $referencia->pago_celular = $res['pagoCelular'];
        $referencia->pago_telefono = $res['pagoTelefono'];
        $referencia->pago_ext_telefono = $res['pagoExtTelefono'];
        return $referencia;
    }
    private function fillEmpresaNatural(Request $request)
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
    private function fillEmpresaJuridica(Request $request)
    {
        $res = $request->empresa;
        $empresa = new ClienteEmpresa();
        $empresa->razon_social = $res['razonSocial'];
        $empresa->actividad_economica = $res['actividadEconomica'];
        $empresa->ruc = $res['ruc'];
        $empresa->cosntitucion_anios = $res['cosntitucionAnios'];
        $empresa->cosntitucion_meses = $res['cosntitucionMeses'];
        $empresa->provincia = $res['provincia'];
        $empresa->ciudad = $res['ciudad'];
        $empresa->calle_principal = $res['callePrincipal'];
        $empresa->calle_secundaria = $res['calleSecundaria'];
        $empresa->no_casa = $res['noCasa'];
        $empresa->sector = $res['sector'];
        $empresa->telefono = $res['telefono'];
        $empresa->celular = $res['celular'];
        $empresa->correo = $res['correo'];
        $empresa->instalaciones = $res['instalaciones'];
        $empresa->sucursales = $res['sucursales'];
        $empresa->total_pasivos = $res['totalPasivos'];
        $empresa->total_activos = $res['totalActivos'];
        $empresa->total_patrimonio = $res['totalPatrimonio'];
        return $empresa;
    }
    private function fillClienteJuridica(Request $request)
    {
        $res = $request->cliente;
        $cliente = new SolicitudCliente();
        $cliente->nombre_completo = $res['nombreCompleto'];
        $cliente->cedula = $res['cedula'];
        $cliente->pasaporte = $res['pasaporte'];
        $cliente->ruc = $res['ruc'];
        $cliente->estado_civil = $res['estadoCivil'];
        $cliente->separacion_bienes = $res['separacionBienes'];
        $cliente->carga_familiar = $res['cargaFamiliar'];
        $cliente->cyg_nombre_completo = $res['cygNombreCompleto'];
        $cliente->cyg_cedula = $res['cygCedula'];
        $cliente->provincia = $res['provincia'];
        $cliente->ciudad = $res['ciudad'];
        $cliente->calle_principal = $res['callePrincipal'];
        $cliente->calle_secundaria = $res['calleSecundaria'];
        $cliente->no_casa = $res['noCasa'];
        $cliente->sector = $res['sector'];
        $cliente->telefono = $res['telefono'];
        $cliente->celular = $res['celular'];
        $cliente->correo = $res['correo'];
        $cliente->casa_tipo = $res['casaTipo'];
        $cliente->tiempo_residencia = $res['tiempoResidencia'];
        $cliente->persona_tipo = $res['personaTipo'];
        return $cliente;
    }
    private function fillClienteNatural(Request $request)
    {
        $res = $request->cliente;
        $cliente = new SolicitudCliente();
        $cliente->nombre_completo = $res["nombreCompleto"];
        $cliente->cedula = $res["cedula"];
        $cliente->pasaporte = $res["pasaporte"];
        $cliente->nacionalidad = $res["nacionalidad"];
        $cliente->ruc = $res["ruc"];
        $cliente->estado_civil = $res["estadoCivil"];
        $cliente->separacion_bienes = $res["separacionBienes"];
        $cliente->carga_familiar = $res["cargaFamiliar"];
        $cliente->cyg_nombre_completo = $res["cygNombreCompleto"];
        $cliente->cyg_cedula = $res["cygCedula"];
        $cliente->cyg_nacionalidad = $res["cygNacionalidad"];
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
    private function conexionProveedor()
    {
        $data = [
            "tipo_cliente"=> "PERSONA NATURAL",
            "cotizacion_referencia"=> "11695",
            "cliente_tipoDocumento"=> "CEDULA",
            "cliente_documentoIdentificacion"=> "1716562226",
            "cliente_nombres"=> "MARIA ISABEL",
            "cliente_apellidos"=> "PAZMI\u00d1O ROSERO",
            "vehiculo_precioContado"=> "25890.00",
            "vehiculo_valorEntrada"=> "25890.00",
            "vehiculo_plazo"=> 0,
            "variables"=> [
                "cotizacion_linea"=> "NUEVOS",
                "concesionario_uid"=> "01",
                "cotizacion_potencialidad"=> "A",
                "cotizacion_tipoSolicitante"=> "Deudor",
                "cotizacion_tipoFinanciacion"=> "FINANMOTROS S.A. CONSORCIO",
                "cotizacion_fechaSolicitud"=> "2022-04-27",
                "garantia_vendedorCedula"=> "1720076551",
                "garantia_vendedorNombres"=> "CRISTIAN GEOVANNY",
                "garantia_vendedorApellidos"=> "CAYO FARINANGO",
                "garantia_vendedorCorreo"=> "cgcayo@suzukiecuador.com",
                "no_cia"=> "SZK DEL ECUADOR S.A.",
                "cliente_genero"=> "FEMENINO",
                "cliente_estadoCivil"=> "CASADO\/A",
                "cliente_nacionalidad"=> "ECUATORIANA",
                "cliente_fechaNacimiento"=> "1987-12-14",
                "cliente_provincia"=> "PICHINCHA",
                "cliente_canton"=> "QUITO",
                "cliente_parroquia"=> "NAY\u00d3N",
                "cliente_callePrincipal"=> "LEONARDO TEJADA Y CAMINO ANTIGUO A NAYON",
                "cliente_tiempoResidenciaAnios"=> "",
                "cliente_tipoVivienda"=> "PROPIA HIPOTECADA",
                "cliente_telefonoFijo"=> "021123564",
                "cliente_cargasFamiliares"=> "0",
                "cliente_separacionBienes"=> "",
                "cliente_celular"=> "0968947319",
                "cliente_email"=> "isabelguerrar@gmail.com",
                "cliente_nivelInstruccion"=> "",
                "cliente_origenIngresosProfesion"=> "",
                "cliente_origenIngresos"=> "",
                "cotizacion_observacion"=> "",
                "cliente_TieneDiscapacidad"=> "N",
                "cliente_origenIngresosLugarTrabajo"=> "INNOVA CONSTRUCTORES ",
                "cliente_origenIngresosActividadEconomica"=> "Empleado Privado",
                "cliente_ActEcoDependienteAniosTrabajo"=> "",
                "cliente_ActEcoDependienteCargo"=> "directora de obra ",
                "cliente_ActEcoIndependienteDescripcionLineaNegocio"=> "",
                "cliente_origenIngresosProvincia"=> "PICHINCHA",
                "cliente_origenIngresosCanton"=> "",
                "cliente_origenIngresosParroquia"=> "",
                "cliente_origenIngresosCallePrincipal"=> "QUITO",
                "cliente_origenIngresosNumeroCasa"=> "",
                "cliente_origenIngresosTelefono"=> "958735195",
                "cliente_origenIngresosRelacionLaboral"=> "FIJO",
                "cliente_origenIngresosTipoLocal"=> "",
                "cliente_origenIngresosNumeroTrabajadores"=> "0",
                "cliente_origenIngresosObligadoContabilidad"=> "",
                "clienteConyugue_documentoIdentificacion"=> "1724263296",
                "clienteConyugue_apellidos"=> "",
                "clienteConyugue_nombres"=> "JAIME MIGUEL ANDRADE MI\u00d1O",
                "clienteConyugue_fechaNacimiento"=> "",
                "clienteConyugue_origenIngresos"=> "",
                "clienteConyugue_otrosIngresos"=> "0.00",
                "clienteConyugue_totalIngresos"=> "1500.00",
                "clienteConyugue_origenIngresosLugarTrabajo"=> "EMPRESA DISE\u00d1O GRAFICO",
                "clienteConyugue_ActEcoDependienteCargo"=> "PROPIETARIO DE NEGOCIOS",
                "clienteConyugue_origenIngresosCallePrincipal"=> "QUITO",
                "clienteConyugue_origenIngresosActividadEconomica"=> "Empleado Privado",
                "clienteConyugue_ActEcoDependienteAniosTrabajo"=> "",
                "clienteConyugue_nacionalidad"=> "ECUATORIANA",
                "clienteConyugue_origenIngresosProvincia"=> "PICHINCHA",
                "clienteConyugue_origenIngresosCanton"=> "QUITO",
                "clienteConyugue_origenIngresosRelacionLaboral"=> "",
                "clienteConyugue_origenIngresosNumeroCasa"=> "",
                "clienteConyugue_origenIngresosTelefono"=> "095873579",
                "vehiculo_marca"=> "SUZUKI",
                "vehiculo_modelo"=> "VITARA GL PLUS AC 1.6 5P 4X2 TM",
                "garantia_clase"=> "JEEP",
                "garantia_subclase"=> "JEEP",
                "garantia_color"=> "BLANCO",
                "garantia_motor"=> "NA",
                "vehiculo_anio"=> "2023",
                "vehiculo_placa"=> "",
                "garantia_chasis"=> "",
                "vehiculo_uso"=> "PARTICULAR",
                "garantia_vendedorAnterior_nombre1"=> "CRISTIAN GEOVANNY",
                "garantia_vendedorAnterior_apellidoPaterno"=> "CAYO",
                "garantia_vendedorAnterior_identificacion"=> "1720076551",
                "garantia_vendedorAnterior_precio"=> "",
                "vehiculo_producto"=> "N",
                "vehiculo_wsAccesorios"=> "267.86",
                "vehiculo_wsDescuento"=> "0.00",
                "vehiculo_valor"=> "22848.20",
                "vehiculo_valorFinanciar"=> "0.00",
                "vehiculo_cuota"=> "0.00",
                "cliente_infFinancieraDepSueldoMensual"=> "3000.00",
                "cliente_infFinancieraDepSueldoConyuge"=> "1500.00",
                "cliente_infFinancieraDepOtrosIngresos"=> "0.00",
                "cliente_infFinancieraDepTotalIngresos"=> "3000.00",
                "cliente_infFinancieraDepGastosFamiliares"=> "300.00",
                "cliente_infFinancieraDepCuotasTarjetas"=> "0.00",
                "cliente_infFinancieraDepCuotasPrestamos"=> "0.00",
                "cliente_infFinancieraDepTotalEgresos"=> "900.00",
                "cliente_infFinancieraGastosAlquiler"=> "0.00",
                "cliente_infFinancieraGastosAlimentacion"=> "600.00",
                "cliente_infFinancieraIndepTotalVentas"=> "3000.00",
                "cliente_infFinancieraIndepHonorariosProfesionales"=> "0.00",
                "cliente_infFinancieraIndepOtrosIngresos"=> "0.00",
                "cliente_infFinancieraIndepTotalIngresos"=> "3000.00",
                "cliente_infFinancieraIndepGastosFamiliares"=> "900.00",
                "cliente_infFinancieraIndepOtrosGastos"=> "300.00",
                "cliente_infFinancieraIndepGastosNegocio"=> "0.00",
                "cliente_infFinancieraIndepCuotasTarjetas"=> "0.00",
                "cliente_infFinancieraIndepCuotasPrestamos"=> "0.00",
                "cliente_infFinancieraIndepTotalEgresos"=> "300.00",
                "cliente_infFinancieraActEntrada"=> "0.00",
                "cliente_infFinancieraActInversiones"=> "0.00",
                "cliente_infFinancieraActInmuebles"=> "0.00",
                "cliente_infFinancieraActOtrosVehiculos"=> "0.00",
                "cliente_infFinancieraActTotalInventario"=> "0.00",
                "cliente_infFinancieraActOtrosActivos"=> "0.00",
                "cliente_infFinancieraActTotalActivos"=> "200000.00",
                "cliente_infFinancieraPavPrestamos"=> "0.00",
                "cliente_infFinancieraPavTarjetasCredito"=> "0.00",
                "cliente_infFinancieraPavOtrasObligaciones"=> "0.00",
                "cliente_infFinancieraPavTotalPasivos"=> "25000.00",
                "cliente_infFinancieraPatrimonio"=> "175000.00",
                "cliente_infFinancieraOrigenFondo"=> "AHORROS, VENTA DE USADO",
                "cliente_infFinancieraDestinoFondo"=> "VEH. NUEVOS SUZUKI"
            ],
            "bienesVehiculos"=> [],
            "bienesInmuebles"=> [],
            "cliente_grdReferenciasPersonales"=> [
                [
                    "cliente_referNombre"=> "PAZMI\u00d1O ROSERO MARIA ISABEL PAZMI\u00d1O ROSERO",
                    "cliente_referTelefono"=> "021223568",
                    "cliente_referCelular"=> ""
                ]
            ],
            "cliente_grdReferenciasBancarias"=> [
                [
                    "cliente_referInstitucionFinanciera"=> "",
                    "cliente_referTipoCuenta"=> "",
                    "cliente_referNumeroCuenta"=> ""
                ]
            ],
            "cliente_grdReferenciasTarjetas"=> [
                [
                    "cliente_referTarjetaCredito"=> "N\/A",
                    "cliente_referNumeroTarjeta"=> "N\/A",
                    "bancoEmisor"=> ""
                ]
            ],
            "cliente_grdReferenciasFamiliares"=> [],
            "cliente_grdReferenciasComerciales"=> [
                [
                    "cliente_referEstablecimiento"=> "",
                    "ciudadComercial"=> "",
                    "telefonoComercial"=> ""
                ]
            ]
        ];
        $response = Http::withOptions([
            'strict'          => false,
            'referer'         => false,
            'protocols'       => ['http', 'https'],
            'track_redirects' => false,
            'verify' => false
        ])
            ->withToken('Bearer 80|KF4CeMPHuit3vnAqAUd5ODcS8LGDIgj4Mei9f9at')
            ->post('https://credito.app.epicentro-digital.com/casabaca_test/api/recibirSolicitud', $data);
        return $response->body();
    }
}

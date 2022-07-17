<?php

namespace App\Http\Controllers\SolicitudCredito;

use App\Http\Controllers\Controller;
use App\Models\SolicitudCredito\ClienteEmpresa;
use App\Models\SolicitudCredito\ClientePatrimonio;
use App\Models\SolicitudCredito\ClienteReferencia;
use App\Models\SolicitudCredito\SolicitudCliente;
use App\Models\SolicitudCredito\SolicitudCredito;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaJuridicaController extends Controller
{

    public function create(Request $request)
    {
        $compania = $request->query("compania");
        $tipoPersona = $request->query("persona");
        try {
            DB::connection(get_connection())->beginTransaction();
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
                    $patrimonio->cliente_id = $cliente->id;
                    $patrimonio->save();
                }
            }
            DB::connection(get_connection())->commit();
            return response()->json([
                "success" => "Guardado exitoso",
                "dowmload" => route("dowmload.solicitud.credito",[$compania, $tipoPersona, $solicitud->id_cotizacion])
            ], 200);
        } catch (\Exception $e) {
            DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }

    private function fillSolicitud(Request $request)
    {
        $res = $request->solicitudCredito;
        $solicitud = new SolicitudCredito();
        $solicitud->id_cotizacion = $res['idCotizacion'];
        $solicitud->producto = $res['producto'];
        $solicitud->valor_producto = floatval($res['valorProducto']);
        $solicitud->entrada = floatval($res['entrada']);
        $solicitud->valor_financiar = floatval($res['valorFinanciar']);
        $solicitud->plazo = intval($res['plazo']);
        $solicitud->fecha_solicitud = Carbon::parse($res['fechaSolicitud']);
        $solicitud->asesor = $res['asesor'];
        $solicitud->agencia = $res['agencia'];
        $solicitud->financiamiento = $res["financiamiento"];
        $solicitud->cedula_cliente = $request->cliente['cedula'];
        return $solicitud;
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

    public function fillPatrimonio($value)
    {
        $patrimonio = new ClientePatrimonio();
        $patrimonio->bien_inmueble = $value['bienInmueble'];
        $patrimonio->ciudad_direccion = $value['ciudadDireccion'];
        $patrimonio->hipotecado = $value['hipotecado'];
        $patrimonio->marca_vehiculo = $value['marcaVehiculo'];
        $patrimonio->modelo_vehiculo = $value['modeloVehiculo'];
        $patrimonio->anio = intval($value['anio']);
        $patrimonio->prendado = $value['prendado'];
        $patrimonio->valor_comercial = floatval($value['valorComercial']);
        $patrimonio->patrimonio_tipo = $value['tipo'];
        return $patrimonio;
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

}

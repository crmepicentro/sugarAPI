<?php

namespace App\Http\Controllers;

use App\Models\CuotaAlcance;
use App\Models\CuotaAlcance\CuotaArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CuotaDeAlcanceController extends Controller
{
    public function create(Request $request)
    {
        try {
            DB::connection(get_connection())->beginTransaction();
            $cuota = $this->fillCuota($request);
            $cuota->save();
            DB::connection(get_connection())->commit();
            return response()->json(["success" => "Guardado exitoso"], 200);
        } catch (\Exception $e) {
            DB::connection(get_connection())->rollBack();
            return response()->json(["error" => $e . " - Notifique a SUGAR CRM Casabaca"], 500);
        }
    }
    public function uploadFile(Request $request)
    {
        $id_cuota = $request->query('idCuota');
        $tipo = $request->query('tipo');
        $file = $request->file('file');
        $path = 'cuotas-alcance';
        $nombre = md5($file.microtime());
        $extencion = $file->getClientOriginalExtension();
        $fileName = $nombre.'.'.$extencion;
        try {
            $file->storeAs($path, $fileName);
            CuotaArchivo::updateOrCreate([
                'id_cuota_alcance' => $id_cuota,
                'tipo' => $tipo,
                'borrado' => 1
            ],[
                'id_cuota_alcance' => $id_cuota,
                'nombre' => $fileName,
                'tipo' => $tipo,
                'borrado' => 0
            ]);
            return response()->json(['success' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e . " - Notifique a SUGAR CRM Casabaca"], 500);
        }
    }

    public function showFiles($idCuota)
    {
        $data = CuotaArchivo::where('id_cuota_alcance', $idCuota)->where('borrado', false)->get();
        $files=[];
        foreach ($data as $key => $value) {
            list($nombre, $extension) = explode('.', $value->nombre);
            $files[] = [
                'nombre' => $nombre,
                'extension' => $extension,
                'tipo' => $value->tipo,
                'url_view' => route( 'file.cuota.alcance', $value->nombre),
                'url_delete' => route('delete.file.cuota', [
                    $value->id_cuota_alcance,
                    $value->id,
                    $value->nombre
                ])
            ];
        }
        return response()->json(['success' => $files], 200);
    }

    public function deleteFile($idCuota, $id, $nombre)
    {
        $path='cutas-alcance/'.$nombre;
        try {
            Storage::delete($path);
            CuotaArchivo::where('id', $id)
                            ->where('id_cuota_alcance',$idCuota)
                            ->update([ "borrado" => true ]);
            return response()->json(['success' => 'Archivo borrado'], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e . " - Notifique a SUGAR CRM Casabaca"], 500);
        }
    }

    public function fillCuota($res)
    {
        $cuota = new CuotaAlcance();
        $cuota->cuaota_alcance = $res['cuaota_alcance'];
        $cuota->cuota = $res['cuota'];
        $cuota->descuento = $res['descuento'];
        $cuota->entrada = $res['entrada'];
        $cuota->f_banco = $res['f_banco'];
        $cuota->f_saldo_financiar = $res['f_saldo_financiar'];
        $cuota->f_tiempo_financiar = $res['f_tiempo_financiar'];
        $cuota->fecha_alcance = $res['fecha_alcance'];
        $cuota->financiamiento = $res['financiamiento'];
        $cuota->financiera = $res['financiera'];
        $cuota->ib_anios_1 = $res['ib_anios_1'];
        $cuota->ib_anios_2 = $res['ib_anios_2'];
        $cuota->ib_banco_1 = $res['ib_banco_1'];
        $cuota->ib_banco_2 = $res['ib_banco_2'];
        $cuota->ib_no_cuenta_1 = $res['ib_no_cuenta_1'];
        $cuota->ib_no_cuenta_2 = $res['ib_no_cuenta_2'];
        $cuota->ib_tipo_cuenta_1 = $res['ib_tipo_cuenta_1'];
        $cuota->ib_tipo_cuenta_2 = $res['ib_tipo_cuenta_2'];
        $cuota->intereses = $res['intereses'];
        $cuota->iva = $res['iva'];
        $cuota->neto = $res['neto'];
        $cuota->no_cuotas = $res['no_cuotas'];
        $cuota->oc_empresa = $res['oc_empresa'];
        $cuota->oc_orden = $res['oc_orden'];
        $cuota->oc_valor = $res['oc_valor'];
        $cuota->orden_compra = $res['orden_compra'];
        $cuota->otros = $res['otros'];
        $cuota->otros_cargos = $res['otros_cargos'];
        $cuota->otros_formas = $res['otros_formas'];
        $cuota->otros_valor = $res['otros_valor'];
        $cuota->poliza = $res['poliza'];
        $cuota->poliza_banco = $res['poliza_banco'];
        $cuota->poliza_fecha_vencimiento = $res['poliza_fecha_vencimiento'];
        $cuota->poliza_valor = $res['poliza_valor'];
        $cuota->porcentaje = $res['porcentaje'];
        $cuota->rc_descripcion_ubicacion_1 = $res['rc_descripcion_ubicacion_1'];
        $cuota->rc_descripcion_ubicacion_2 = $res['rc_descripcion_ubicacion_2'];
        $cuota->rc_descripcion_ubicacion_3 = $res['rc_descripcion_ubicacion_3'];
        $cuota->rc_descripcion_ubicacion_4 = $res['rc_descripcion_ubicacion_4'];
        $cuota->rc_empresa_1 = $res['rc_empresa_1'];
        $cuota->rc_empresa_2 = $res['rc_empresa_2'];
        $cuota->rc_monto_compra_1 = $res['rc_monto_compra_1'];
        $cuota->rc_monto_compra_2 = $res['rc_monto_compra_2'];
        $cuota->rc_tiempo_relacion_1 = $res['rc_tiempo_relacion_1'];
        $cuota->rc_tiempo_relacion_2 = $res['rc_tiempo_relacion_2'];
        $cuota->rc_tipo_empresa_1 = $res['rc_tipo_empresa_1'];
        $cuota->rc_tipo_empresa_2 = $res['rc_tipo_empresa_2'];
        $cuota->rc_total_bienes = $res['rc_total_bienes'];
        $cuota->rc_valor_comercial_1 = $res['rc_valor_comercial_1'];
        $cuota->rc_valor_comercial_2 = $res['rc_valor_comercial_2'];
        $cuota->rc_valor_comercial_3 = $res['rc_valor_comercial_3'];
        $cuota->rc_valor_comercial_4 = $res['rc_valor_comercial_4'];
        $cuota->rc_valor_deuda_1 = $res['rc_valor_deuda_1'];
        $cuota->rc_valor_deuda_2 = $res['rc_valor_deuda_2'];
        $cuota->rc_valor_deuda_3 = $res['rc_valor_deuda_3'];
        $cuota->rc_valor_deuda_4 = $res['rc_valor_deuda_4'];
        $cuota->rf_apellidos_1 = $res['rf_apellidos_1'];
        $cuota->rf_apellidos_2 = $res['rf_apellidos_2'];
        $cuota->rf_celular_1 = $res['rf_celular_1'];
        $cuota->rf_celular_2 = $res['rf_celular_2'];
        $cuota->rf_nombres_1 = $res['rf_nombres_1'];
        $cuota->rf_nombres_2 = $res['rf_nombres_2'];
        $cuota->rf_parentezco_1 = $res['rf_parentezco_1'];
        $cuota->rf_parentezco_2 = $res['rf_parentezco_2'];
        $cuota->rf_provincia_1 = $res['rf_provincia_1'];
        $cuota->rf_provincia_2 = $res['rf_provincia_2'];
        $cuota->rf_telefono_1 = $res['rf_telefono_1'];
        $cuota->rf_telefono_2 = $res['rf_telefono_2'];
        $cuota->rp_apellidos_1 = $res['rp_apellidos_1'];
        $cuota->rp_apellidos_2 = $res['rp_apellidos_2'];
        $cuota->rp_celular_1 = $res['rp_celular_1'];
        $cuota->rp_celular_2 = $res['rp_celular_2'];
        $cuota->rp_nombres_1 = $res['rp_nombres_1'];
        $cuota->rp_nombres_2 = $res['rp_nombres_2'];
        $cuota->rp_provincia_1 = $res['rp_provincia_1'];
        $cuota->rp_provincia_2 = $res['rp_provincia_2'];
        $cuota->rp_telefono_1 = $res['rp_telefono_1'];
        $cuota->rp_telefono_2 = $res['rp_telefono_2'];
        $cuota->saldo_financiado = $res['saldo_financiado'];
        $cuota->saldo_financiar = $res['saldo_financiar'];
        $cuota->seguro_financiado = $res['seguro_financiado'];
        $cuota->seguro_meses = $res['seguro_meses'];
        $cuota->tarjeta_credito = $res['tarjeta_credito'];
        $cuota->tc_tarjeta = $res['tc_tarjeta'];
        $cuota->tc_valor_tarjeta = $res['tc_valor_tarjeta'];
        $cuota->tipo_pago = $res['tipo_pago'];
        $cuota->toma_vehiculo = $res['toma_vehiculo'];
        $cuota->total = $res['total'];
        $cuota->tv_avaluo = $res['tv_avaluo'];
        $cuota->tv_b_coach = $res['tv_b_coach'];
        $cuota->tv_b_trade_in = $res['tv_b_trade_in'];
        $cuota->tv_modelo = $res['tv_modelo'];
        $cuota->tv_valor = $res['tv_valor'];
        $cuota->v_vehiculo_anio = $res['v_vehiculo_anio'];
        $cuota->v_vehiculo_marca = $res['v_vehiculo_marca'];
        $cuota->v_vehiculo_modelo = $res['v_vehiculo_modelo'];
        $cuota->v_vehiculo_valor = $res['v_vehiculo_valor'];
        $cuota->valor = $res['valor'];
        $cuota->valor_accesorios = $res['valor_accesorios'];
        $cuota->valor_seguro = $res['valor_seguro'];
        $cuota->vehiculo = $res['vehiculo'];
        $cuota->venta_vehiculo = $res['venta_vehiculo'];
        return $cuota;
    }
}

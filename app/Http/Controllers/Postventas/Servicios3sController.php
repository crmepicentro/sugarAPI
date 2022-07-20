<?php

namespace App\Http\Controllers\Postventas;

use App\Http\Controllers\Controller;
use App\Jobs\CargaFacturasDetalleDia;
use App\Jobs\CargaFacturasDia;
use App\Jobs\ChequearStock;
use App\Models\Gestion\GestionCita;
use App\Models\Postventas\Auto;
use App\Models\Postventas\AutoFactura;
use App\Models\Postventas\AutoUsuarioauto;
use App\Models\Postventas\DetalleGestionOportunidades;
use App\Models\Postventas\Factura;
use App\Models\Postventas\GestionAgendado;
use App\Models\Postventas\Propietario;
use App\Models\Postventas\StockRepuestos;
use App\Models\Postventas\Usuarioauto;
use App\Models\Ws_logs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Response;

class Servicios3sController extends Controller
{
    /** constructor  */
    public function __construct()
    {
        $this->middleware(['sugarauth'])->except(['consultaApiCabecera_bulk']);
    }
    public function consultaApiCabecera_main( $fecha_inicial, $fecha_final )
    {
        $url = config('constants.pv_url_servicio').'/casabacaWebservices/restOrdenTaller/consultaOrdenTallerDet';
        $getdata = [
            'idEmpresa'         => config('constants.pv_empresa'),
            'codOrdenEstado'    => config('constants.pv_codOrdenEstado'),
            'fechaInicial'      => $fecha_inicial,
            'fechaFinal'        => $fecha_final,
            'codOrdenTaller'    => config('constants.pv_codOrdenTaller'),
        ];
        $consulta_id = Str::uuid().'.txt';
        $response = Http::withBasicAuth(config('constants.pv_user_servicio'), config('constants.pv_pass_servicio'))->get($url,$getdata);
        $respuesta = $response->json();
        Storage::disk('pv_data_cabe')->put($consulta_id, json_encode($respuesta));
        $ws_logs = Ws_logs::create([
            'route' => 'consultaApiCabecera_main/'.$url,
            'datos_sugar_crm' => 'Consulta_consultaOrdenTallerDet',
            'datos_adicionales' => json_encode($getdata),
            'response' => $consulta_id,
            'remember_token' => md5(json_encode($respuesta)),
            "environment" => get_connection(),
            "source" => md5(json_encode($respuesta)),
            'interaccion_id' => '-leido-',
        ]);
        if( $respuesta['nomMensaje'] == 'ERROR' ){
            $ws_logs->update([
                'response' => json_encode($respuesta),
                'interaccion_id' => '-error-',
            ]);
        }
        $respuesta['ws_logs'] = $ws_logs->id;
        return $respuesta;
    }
    public function consultaApiCabecera_orden( $orden )
    {
        $url = config('constants.pv_url_servicio').'/casabacaWebservices/restOrdenTaller/consultaOrdenTallerDet';
        $getdata = [
            'idEmpresa'         => config('constants.pv_empresa'),
            'codOrdenEstado'    => 0,
            'fechaInicial'      => Carbon::now()->subYears(4)->format(config('constants.pv_dateFormat')),
            'fechaFinal'        => Carbon::now()->format(config('constants.pv_dateFormat')),
            'codOrdenTaller'    => $orden,
        ];
        $consulta_id = Str::uuid().'.txt';
        $response = Http::withBasicAuth(config('constants.pv_user_servicio'), config('constants.pv_pass_servicio'))->get($url,$getdata);
        if( $response->status() == 200 ) {
            $respuesta = $response->json();
            if ($respuesta['nomMensaje'] == 'ERROR') {
                return [
                    'header' => [],
                    'detalle' => [],
                    'estado' => 'NO_EXISTE',
                ];
            } elseif ($respuesta['nomMensaje'] == 'EXITO') {
                $url = config('constants.pv_url_servicio') . '/casabacaWebservices/restOrdenTaller/consultaOrdenTallerCL';
                $getdata = [
                    'idEmpresa' => config('constants.pv_empresa'),
                    'codAgencia' => $respuesta['listaOrdenTallerDetalle'][0]['codAgencia'],
                    'codOrdenTaller' => $orden,
                ];
                $response = Http::withBasicAuth(config('constants.pv_user_servicio'), config('constants.pv_pass_servicio'))->get($url, $getdata);
                $respuesta_deta = $response->json();
                if ($respuesta_deta['nomMensaje'] == 'ERROR') {
                    return [
                        'header' => $respuesta['listaOrdenTallerDetalle'][0],
                        'detalle' => [],
                        'estado' => 'INCOMPLETO',
                    ];
                } elseif ($respuesta_deta['nomMensaje'] == 'EXITO') {
                    return [
                        'header' => $respuesta['listaOrdenTallerDetalle'][0],
                        'detalle' => $respuesta_deta['listaOrdenTallerCL'],
                        'estado' => 'COMPLETO',
                    ];
                }
            }
        }
        return [
            'header' => [],
            'detalle' => [],
            'estado' => 'NO_EXISTE',
        ];
    }

    public function registrarOrdenTallerCls(GestionAgendado $gestionAgendado)
    {
        $url = config('constants.pv_url_servicio') . '/casabacaWebservices/restOrdenTaller/registrarOrdenTallerCL';
        $getdata = $gestionAgendado->citas3s;
        try{
            Log::channel('log_consulta_bms')->info(print_r( ['url'=>$url, 'getdata' => json_encode($getdata) ] ,true ));
            $response = Http::withBasicAuth(config('constants.pv_user_servicio'), config('constants.pv_pass_servicio'))->post($url, $getdata);
            Log::channel('log_consulta_bms')->info(print_r( $response->body(),true ));
            $respuesta = $response->json();
            $consulta_id = Str::uuid().'.txt';
            Storage::disk('pv_data_cabe')->put($consulta_id, json_encode($respuesta));
            $ws_logs = Ws_logs::create([
                'route' => 'registrarOrdenTallerCls/'.$url,
                'datos_sugar_crm' => 'registrarOrdenTallerCL',
                'datos_adicionales' => json_encode($getdata),
                'response' => $consulta_id,
                'remember_token' => md5(json_encode($respuesta)),
                "environment" => get_connection(),
                "source" => md5(json_encode($respuesta)),
                'interaccion_id' => '-leido-',
            ]);
            $gestionAgendado->codigo_seguimiento_resp_s3s = $respuesta['codTransacion'];
            $gestionAgendado->save();
            return $gestionAgendado;
        }catch (\Exception $e) {
            // borra la cita o gestion
            $gestion = GestionAgendado::create([
                'users_id' => auth()->user()->id,
                'codigo_seguimiento' => Str::uuid(),
            ]);
            foreach ($gestionAgendado->detalleoportunidadcitas as $detalleoportunidadcita) {
                $cita_borrada = GestionCita::create([
                    'detalle_gestion_oportunidad_id' => $detalleoportunidadcita->id,
                    'gestion_agendado_id' => $gestion->id,
                    'tipo_gestion' => 'borrar_cita'
                ]);
                $cita_borrada->save();
            }
            //$gestionAgendado->delete();
            throw new \Exception('No se pudo conectar al sistema S3S.');
        }

    }
    public function conOrdCLsRecuperados($codAgencia,$placaVehiculo)
    {
        $url = config('constants.pv_url_servicio') . '/casabacaWebservices/restOrdenTaller/conOrdCLsRecuperados';
        $getdata = [
            'idEmpresa' => config('constants.pv_empresa'),
            // 'codAgencia' => $codAgencia,
            'placaVehiculo' => $placaVehiculo,
        ];
        Log::channel('log_consulta_bms')->info(print_r( ['url'=>$url, 'getdata' => json_encode($getdata) ] ,true ));
        $response = Http::withBasicAuth(config('constants.pv_user_servicio'), config('constants.pv_pass_servicio'))->get($url, $getdata);
        Log::channel('log_consulta_bms')->info(print_r( $response->body(),true ));
        //dd($response,config('constants.pv_user_servicio'),config('constants.pv_pass_servicio'),$url,$getdata);
        $respuesta = $response->json();
        return $respuesta;
    }

    public function cancelar_gestion($detalle_gestion_oportunidad_id){
        try {
            $gestion = GestionAgendado::create([
                'users_id' => auth()->user()->id,
                'codigo_seguimiento' => Str::uuid(),
            ]);
            $cita_borrada = GestionCita::create([
                'detalle_gestion_oportunidad_id' => $detalle_gestion_oportunidad_id,
                'gestion_agendado_id' => $gestion->id,
                'tipo_gestion' => 'borrar_cita'
            ]);
            $cita_borrada->save();
            return true;
        }catch ( \Exception $exception){
            Log::channel('log_consulta_bms')->info(print_r( ['detalle_gestion_oportunidad_id'=>$detalle_gestion_oportunidad_id, 'error' => $exception ] ,true ));
            return false;
        }
    }
    public function gestion_cambio_estado($detalle_gestion_oportunidad_id,$gestion){
        try {
            $gestion->save();
            $cita_borrada = GestionCita::create([
                'detalle_gestion_oportunidad_id' => $detalle_gestion_oportunidad_id,
                'gestion_agendado_id' => $gestion->id,
                'tipo_gestion' => 'cita_ok'
            ]);
            $cita_borrada->save();
            return true;
        }catch ( \Exception $exception){
            Log::channel('log_consulta_bms')->info(print_r( ['detalle_gestion_oportunidad_id'=>$detalle_gestion_oportunidad_id, 'error' => $exception ] ,true ));
            return false;
        }
    }

    public function consultaApiDetalleCabecera_main( $codAgencial , $codOrdenTaller )
    {
        $url = config('constants.pv_url_servicio').'/casabacaWebservices/restOrdenTaller/consultaOrdenTallerCL';
        $getdata = [
            'idEmpresa'         => config('constants.pv_empresa'),
            'codAgencia'        => $codAgencial,
            'codOrdenTaller'    => $codOrdenTaller,
        ];
        $consulta_id = Str::uuid().'.txt';
        Log::channel('log_consulta_ordenes')->info(print_r( ['url'=>$url, 'getdata' => json_encode($getdata) ] ,true ));
        $response = Http::withBasicAuth(config('constants.pv_user_servicio'), config('constants.pv_pass_servicio'))->get($url,$getdata);
        Log::channel('log_consulta_ordenes')->info(print_r( $response->body(),true ));
        $respuesta = $response->json();
        Storage::disk('pv_data_cabe_deta')->put($consulta_id, json_encode($respuesta));
        $ws_logs = Ws_logs::create([
            'route' => 'consultaApiDetalleCabecera_main/'.$url,
            'datos_sugar_crm' => 'Consulta_consultaOrdenTallerDetalle',
            'datos_adicionales' => json_encode($getdata),
            'response' => $consulta_id,
            'remember_token' => md5(json_encode($respuesta)),
            "environment" => get_connection(),
            "source" => md5(json_encode($respuesta)),
            'interaccion_id' => '-leido-',
        ]);
        if( $respuesta['nomMensaje'] == 'ERROR' ){
            $ws_logs->update([
                'response' => json_encode($respuesta),
                'interaccion_id' => '-error-',
            ]);
        }
        $respuesta['ws_logs'] = $ws_logs->id;
        return $respuesta;
    }
    public function consultaHistorial_pdf( $placa_vehiculo )
    {
        $auto = Auto::where('placa',$placa_vehiculo)->first();
        if($auto == null){
            return response()->json([
                'mensaje' => 'No se encontró el auto',
                'codigo' => '-1',
            ]);
        }

        if (Cache::has($placa_vehiculo)) {
            return Response::make(Storage::disk('pv_data_cabe_pdf_auto')->get(Cache::get($placa_vehiculo)), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$placa_vehiculo."-".Carbon::now()->format(config('constants.pv_dateFormat')).'.pdf'.'"'
            ]);
        }
        $url = config('constants.pv_url_servicio').'/casabacaWebservices/restOrdenTaller/consultaHistorialVehPdf';
        $getdata = [
            'idEmpresa'         => config('constants.pv_empresa'),
            'placaVehiculo'     => $placa_vehiculo,
        ];
        $consulta_id = Str::uuid().'.pdf';
        $response = Http::withBasicAuth(config('constants.pv_user_servicio'), config('constants.pv_pass_servicio'))->get($url,$getdata);
        $respuesta = $response->body();
        Storage::disk('pv_data_cabe_pdf_auto')->put($consulta_id, $respuesta);
        Cache::put($placa_vehiculo, $consulta_id, now()->addHours(12));
        return Response::make(Storage::disk('pv_data_cabe_pdf_auto')->get($consulta_id), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$placa_vehiculo."-".Carbon::now()->format(config('constants.pv_dateFormat')).'.pdf'.'"'
        ]);

    }
    public function consultaApiCabecera( Request $request)
    {
        //dd($request->all());
        $request->validate([
            'fecha' => 'date',
        ]);

        if(!$request->exists('fecha')){
            $dias = 12;
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $day = Carbon::now()->subDays($dias + 2 )->day;
            $tz = config('constants.pv_timezone');
            $fecha_inicial = Carbon::createFromDate($year, $month, $day, $tz); //2022-04-10 no tiene datos
        }else{
            $fecha_inicial = Carbon::createFromDate($request->fecha);
        }
        CargaFacturasDia::dispatch($fecha_inicial)->onQueue('cargaCabecera');

    }
    public function consultaApiCabecera_bulk( Request $request)
    {
        $request->validate([
            'ejecutar' => 'required|in:ecHuWh2mf80V3FlWA3LW9wn2Hjkka9asZmuOirYGZYROU5ejlVoyzo2aJ437sxRO0OfpoCZOFXp6ryLjQrIBS79fgb6Ry3LeK7SgwTTg',
        ]);

        for ($i=0; $i < 60; $i++) {
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $day = Carbon::now()->day;
            $tz = config('constants.pv_timezone');
            $fecha_inicial = Carbon::createFromDate($year, $month, $day, $tz)->subDays( $i ); //2022-04-10 no tiene datos
            CargaFacturasDia::dispatch($fecha_inicial)->onQueue('cargaCabecera');
        }
        return response()->json([
            'mensaje' => 'Proceso iniciado',
            'codigo' => '0',
            'datos' => $i,
        ]);


    }
    public function insertarRegistrosDeOrdenes ( Request $request)
    {

        $request->validate([
            'placaVehiculo' => 'required',
            'usuarioCrea' => 'required',
            'ciPropietario' => 'required',
            'codAgencia' => 'required',
            'gestionComentario' => 'required',
            'gestionId' => 'required',
            'ordTallerRef' => 'required',
        ]);

        for ($i=0; $i < 10; $i++) {
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $day = Carbon::now()->day;
            $tz = config('constants.pv_timezone');
            $fecha_inicial = Carbon::createFromDate($year, $month, $day, $tz)->subDays($i ); //2022-04-10 no tiene datos
            CargaFacturasDia::dispatch($fecha_inicial)->onQueue('cargaCabecera');
        }
        return response()->json([
            'mensaje' => 'Proceso iniciado',
            'codigo' => '0',
            'datos' => $i,
        ]);


    }
    public function guardar_consulta( $fecha_inicial, $fecha_final )
    {
        //dd( $fecha_inicial, $fecha_final );
        $s3sdatos = $this->consultaApiCabecera_main($fecha_inicial, $fecha_final);
        $ws_logs = Ws_logs::find($s3sdatos['ws_logs']);
        if($s3sdatos['nomMensaje'] == 'ERROR' ){
            return response()->view('errors.404', [
                'title' => 'Error',
                'code' => '404',
                'message' => $ws_logs->response,
            ], 404);
            abort(404);
        }
        foreach ($s3sdatos['listaOrdenTallerDetalle'] as $s3sdato){
            $propietario = $this->guardar_propietario($s3sdato,$ws_logs);
            $auto_cabecera = $this->guardar_auto($s3sdato , $propietario, $ws_logs);
            $this->guardar_usuarioauto($s3sdato ,  $ws_logs,$auto_cabecera['auto']);
            $this->guardar_factura($s3sdato , $ws_logs,$auto_cabecera['auto']);
            $auto           = $auto_cabecera['auto'] ;
            $codAgencia     = $auto_cabecera['codAgencia'] ;
            $codOrdenTaller = $auto_cabecera['codOrdenTaller'] ;
            CargaFacturasDetalleDia::dispatch($codAgencia , $codOrdenTaller,$s3sdato,$auto)->onQueue('cargaDetalle');
        }

        return $s3sdatos;
    }
    private function guardar_propietario($s3sdato,Ws_logs $ws_logs){
        $propietario = Propietario::where('codPropietario',$s3sdato['codPropietario'])->first();
        if($propietario != null ){
            $propietario->update([
                'cedula'                => $s3sdato['ciPropietario'],
                'nombre_propietario'    => $s3sdato['nomPropietario'],
                'telefono_domicilio'    => $s3sdato['fonoDomPropietario'],
                'telefono_trabajo'      => $s3sdato['fonoTrabPropietario'],
                'telefono_celular'      => $s3sdato['fonoCelPropietario'],
                'email_propietario'     => $s3sdato['mail1Propietario'],
                'email_propietario_2'   => $s3sdato['mail2Propietario'],
                'id_ws_logs'            => $ws_logs->id,
            ]);
            $propietario->save();
        }
        $propietario = Propietario::firstOrCreate([
            'cedula'                => $s3sdato['ciPropietario'],
            'codPropietario'        => $s3sdato['codPropietario'],
            'nombre_propietario'    => $s3sdato['nomPropietario'],
            'telefono_domicilio'    => $s3sdato['fonoDomPropietario'],
            'telefono_trabajo'      => $s3sdato['fonoTrabPropietario'],
            'telefono_celular'      => $s3sdato['fonoCelPropietario'],
            'email_propietario'     => $s3sdato['mail1Propietario'],
            'email_propietario_2'   => $s3sdato['mail2Propietario'],
            'id_ws_logs'            => $ws_logs->id,
        ]);
        $propietario->save();
        return $propietario;
    }
    private function guardar_usuarioauto($s3sdato,Ws_logs $ws_logs,Auto $auto){
        if(trim($s3sdato['nomUsuarioVista']) == '' && trim($s3sdato['fonoCelUsuarioVisita']) == ''  && trim($s3sdato['mailUsuarioVisita']) == ''
        ){
            return null;
        }
        $usuarioAuto = Usuarioauto::firstOrCreate([
            'nomUsuarioVista'       => $s3sdato['nomUsuarioVista'],
            'fonoCelUsuarioVisita'  => $s3sdato['fonoCelUsuarioVisita'],
            'mailUsuarioVisita'     => trim($s3sdato['mailUsuarioVisita']),
        ]);
        $usuarioAuto->save();
        AutoUsuarioauto::create([
            'autos_id'          => $auto->id,
            'usuarioautos_id'   => $usuarioAuto->id,
        ]);
    }
    private function guardar_factura($s3sdato,Ws_logs $ws_logs,Auto $auto){
        $factura = Factura::where('codCliFactura',$s3sdato['codCliFactura'])->first();
        if($factura == null ){
            $factura = Factura::firstOrCreate([
                'codCliFactura'     => $s3sdato['codCliFactura'],
                'ciCliFactura'      => $s3sdato['ciCliFactura'],
                'nomCliFactura'     => $s3sdato['nomCliFactura'],
                'mail1CliFactura'   => $s3sdato['mail1CliFactura'],
                'mali2CliFactura'   => $s3sdato['mali2CliFactura'],
                'fonoCliDomFactura' => $s3sdato['fonoCliDomFactura'],
                'fonoCliTrabFactura'    => $s3sdato['fonoCliTrabFactura'],
                'fonoCliCelFactura'     => $s3sdato['fonoCliCelFactura'],
            ]);
            $factura->save();
        }
        AutoFactura::firstOrCreate([
            'autos_id'          => $auto->id,
            'factura_id'   => $factura->id,
        ]);
        return $factura;
    }
    private function guardar_auto($s3sdato , Propietario $propietario, Ws_logs $ws_logs){
        $auto = Auto::where('id_auto_s3s',$s3sdato['numcbs'])->first();
        if($auto == null ){
            $auto = Auto::firstOrCreate([
                'propietario_id' => $propietario->id,
                'id_auto_s3s' => $s3sdato['numcbs'],
                'id_ws_logs' => $ws_logs->id,
                'placa'  => $s3sdato['placaVehiculo'],
                'chasis' => $s3sdato['chasisVehiculo'],
                'modelo' => $s3sdato['modeloVehiculo'],
                'descVehiculo' => $s3sdato['descVehiculo'],
                'marcaVehiculo' => $s3sdato['marcaVehiculo'],
                'anioVehiculo' => $s3sdato['anioVehiculo'],
                'masterLocVehiculo' => $s3sdato['masterLocVehiculo'],
                'katashikiVehiculo' => $s3sdato['katashikiVehiculo'],
            ]);
            $auto->save();
        }

        $Retunr_auto['auto'] = $auto;
        $Retunr_auto['codAgencia'] = $s3sdato['codAgencia'];
        $Retunr_auto['codOrdenTaller'] = $s3sdato['ordTaller'];
        return $Retunr_auto;
    }
    public function guardar_detalle_orden($s3sdato,$s3sdato_detalle, Auto $auto, Ws_logs $ws_logs){
        $propietario = DetalleGestionOportunidades::where('codAgencia',$s3sdato_detalle['codAgencia'])
            ->where('ordTaller',$s3sdato_detalle['ordTaller'])
            ->where('codServ',$s3sdato_detalle['codServ'])
            ->first();
        if($propietario == null ){
            $propietario = DetalleGestionOportunidades::firstOrCreate([
                'ws_log_id' => $ws_logs->id,

                'auto_id' => $auto->id,

                'oportunidad_id' => null,

                'codAgencia' => $s3sdato_detalle['codAgencia'],
                'nomAgencia' => $s3sdato_detalle['nomAgencia'],
                'ordTaller'     => $s3sdato_detalle['ordTaller'],
                'kmVehiculo'    => $s3sdato['kmVehiculo'],
                'kmRelVehiculo' => $s3sdato['kmRelVehiculo'],
                'ordFechaCita' => $s3sdato['ordFechaCita'],
                'ordFechaCrea'  => $s3sdato['ordFechaCrea'],
                'ordFchaCierre'     => $s3sdato['ordFchaCierre'],
                'codOrdAsesor'   => $s3sdato['codOrdAsesor'],
                'nomOrdAsesor'  => $s3sdato['nomOrdAsesor'],

                'codServ' => $s3sdato_detalle['codServ'],
                'descServ' => $s3sdato_detalle['descServ'],
                'cantidad'  => $s3sdato_detalle['cantidad'],
                'cargosCobrar' => $s3sdato_detalle['cargosCobrar'],
                'tipoCL' => $s3sdato_detalle['tipoCL'],
                'facturado' => $s3sdato_detalle['facturado'],

                'tipoServ'  => $s3sdato_detalle['tipoServ'],
                'franquicia' => $s3sdato_detalle['franquicia'],
                'codEstOrdTaller' => $s3sdato['codEstOrdTaller'],

                'codCliFactura'  => $s3sdato['codCliFactura'],
                'nomUsuarioVista' => $s3sdato['nomUsuarioVista'],

                'facturacion_fecha' => null,


                'perdida_fecha' =>null,
                'perdida_agente' =>null,
                'perdida_motivo' =>null,

                'ganado_fecha' =>null,
                'ganado_factura' =>null,

                'agendado_fecha' => null,

                'gestion_fecha' =>null,
                'gestion_tipo'  => 'nuevo',

            ]);
            $propietario->save();
        }
        return $propietario;
    }
    public function consultaDisponibilidad(Request $request){
        //http://talleres.casabaca.com/externo/reservar-cita/ajax-listar-asesores?sucursal=005&fecha=2022-05-18
        $sucursal = '005';
        switch ($request->agencia) {
            case 19:
                $sucursal = '005';
                break;
            case 1:
                $sucursal = '005';
                break;
            case 2:
                $sucursal = '005';
                break;
        }
        $response = Http::get('http://talleres.casabaca.com/externo/reservar-cita/ajax-listar-asesores',[
            'sucursal' => $sucursal,
            'fecha' => $request->fecha,
        ]);
        $response = (Object)$response->json();
        return response()->json($response);
    }
    public function setSessionData($session ,$valor, Request $request){
        $request->session()->put($session, $valor);
        Cache::put($session, $valor);
        return session($session);
    }
    public function consultaStock( $codRepuesto, $franquicia )
    {
        $url = config('constants.pv_url_servicio').'/casabacaWebservices/restOrdenTaller/conStockRepuestos';
        $getdata = [
            'idEmpresa'     => config('constants.pv_empresa'),
            'codRepuesto'   => $codRepuesto,
            'franquicia'    => $franquicia,
        ];
        $response = Http::withBasicAuth(config('constants.pv_user_servicio'), config('constants.pv_pass_servicio'))->get($url,$getdata);
        $respuesta = $response->json();
        return $respuesta;
    }
    public function consultaStockBulk( )
    {
        StockRepuestos::query()->delete();
        $vericastkkers = DetalleGestionOportunidades::agestionar()->where('tipoServ','R')->get();
        $contador = 0;
        foreach ($vericastkkers as $vericastkker){
            ChequearStock::dispatch($vericastkker,auth()->user())->onQueue('VerificaStock');
            $contador++;
        }
        return response()->json(['mensaje' => 'Se ha procesado '.$contador.' datos.' ], 202);
    }
}

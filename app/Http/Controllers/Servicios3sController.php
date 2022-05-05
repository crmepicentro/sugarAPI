<?php

namespace App\Http\Controllers;

use App\Jobs\CargaFacturasDia;
use App\Models\Auto;
use App\Models\DetalleGestionOportunidades;
use App\Models\Propietario;
use App\Models\Ws_logs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Response;

class Servicios3sController extends Controller
{
    public function consultaApiCabecera_main( $fecha_inicial, $fecha_final )
    {
        $url = 'https://s3s.casabaca.com/casabacaWebservices/restOrdenTaller/consultaOrdenTallerDet';
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
    public function consultaApiDetalleCabecera_main( $codAgencial , $codOrdenTaller )
    {
        $url = 'https://s3s.casabaca.com/casabacaWebservices/restOrdenTaller/consultaOrdenTallerCL';
        $getdata = [
            'idEmpresa'         => config('constants.pv_empresa'),
            'codAgencia'        => $codAgencial,
            'codOrdenTaller'    => $codOrdenTaller,
        ];
        $consulta_id = Str::uuid().'.txt';
        $response = Http::withBasicAuth(config('constants.pv_user_servicio'), config('constants.pv_pass_servicio'))->get($url,$getdata);
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
        $url = 'https://s3s.casabaca.com/casabacaWebservices/restOrdenTaller/consultaHistorialVehPdf';
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
        CargaFacturasDia::dispatch($fecha_inicial);

    }
    public function consultaApiCabecera_bulk( Request $request)
    {
        $request->validate([
            'ejecutar' => 'required|in:ecHuWh2mf80V3FlWA3LW9wn2Hjkka9asZmuOirYGZYROU5ejlVoyzo2aJ437sxRO0OfpoCZOFXp6ryLjQrIBS79fgb6Ry3LeK7SgwTTg',
        ]);

        for ($i=0; $i < 90; $i++) {
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $day = Carbon::now()->subDays($i + 2 )->day;
            $tz = config('constants.pv_timezone');
            $fecha_inicial = Carbon::createFromDate($year, $month, $day, $tz); //2022-04-10 no tiene datos
            CargaFacturasDia::dispatch($fecha_inicial);
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
            $auto           = $auto_cabecera['auto'] ;
            $codAgencia     = $auto_cabecera['codAgencia'] ;
            $codOrdenTaller = $auto_cabecera['codOrdenTaller'] ;
            $detalle = $this->consultaApiDetalleCabecera_main($codAgencia, $codOrdenTaller);
            $ws_logs = Ws_logs::find($detalle['ws_logs']);

            if($detalle['nomMensaje'] == 'EXITO' ){
                foreach ($detalle['listaOrdenTallerCL'] as $detalle_dato){
                    $this->guardar_detalle_orden($s3sdato,$detalle_dato, $auto, $ws_logs);
                }
            }


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
    private function guardar_auto($s3sdato , Propietario $propietario, Ws_logs $ws_logs){
        $auto = Auto::where('id_auto_s3s',$s3sdato['numcbs'])->first();
        if($auto != null ){
            $auto->update([
                'propietario_id' => $propietario->id,
                'id_auto_s3s' => $s3sdato['numcbs'],
                'id_ws_logs' => $ws_logs->id,
                'placa'  => $s3sdato['placaVehiculo'],
                'modelo' => $s3sdato['modeloVehiculo'],
                'descVehiculo' => $s3sdato['descVehiculo'],
                'marcaVehiculo' => $s3sdato['marcaVehiculo'],
                'anioVehiculo' => $s3sdato['anioVehiculo'],
                'masterLocVehiculo' => $s3sdato['masterLocVehiculo'],
                'katashikiVehiculo' => $s3sdato['katashikiVehiculo'],
            ]);
            $auto->save();
        }
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
        $Retunr_auto['auto'] = $auto;
        $Retunr_auto['codAgencia'] = $s3sdato['codAgencia'];
        $Retunr_auto['codOrdenTaller'] = $s3sdato['ordTaller'];
        return $Retunr_auto;
    }
    private function guardar_detalle_orden($s3sdato,$s3sdato_detalle, Auto $auto, Ws_logs $ws_logs){
        $propietario = DetalleGestionOportunidades::where('codAgencia',$s3sdato_detalle['codAgencia'])
            ->where('ordTaller',$s3sdato_detalle['ordTaller'])
            ->where('codServ',$s3sdato_detalle['codServ'])
            ->first();
        if($propietario != null ){
            $propietario->update([
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

                'facturacion_fecha' => null,

                'perdida_fecha' => null,
                'perdida_agente' => null,
                'perdida_motivo' => null,

                'ganado_fecha' => null,
                'ganado_factura' => null,

                'gestion_fecha' => null,
                'gestion_tipo'  => 'nuevo',
            ]);
            $propietario->save();
        }
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

            'facturacion_fecha' => null,


            'perdida_fecha' =>null,
            'perdida_agente' =>null,
            'perdida_motivo' =>null,

            'ganado_fecha' =>null,
            'ganado_factura' =>null,

            'gestion_fecha' =>null,
            'gestion_tipo'  => 'nuevo',

        ]);
        $propietario->save();
        return $propietario;
    }
}

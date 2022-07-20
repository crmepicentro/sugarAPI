<?php

namespace App\Http\Controllers\Postventas;

use App\Http\Controllers\Controller;
use App\Models\Gestion\GestionCita;
use App\Models\Gestion\GestionDesiste;
use App\Models\Gestion\GestionRecordatorio;
use App\Models\Postventas\Auto;
use App\Models\Postventas\DetalleGestionOportunidades;
use App\Models\Postventas\GestionAgendado;
use App\Models\Postventas\StockRepuestos;
use App\Models\Ws_logs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GestionPostVentaController extends Controller
{
    /** constructor  */
    public function __construct()
    {
        $this->middleware(['sugarauth'])->except('s3spostdatacore_consulta');
    }
    public function gestions3s(Request $request)
    {
        $request->validate([
            'auto' => 'required|exists:pvt_autos,id',
        ]);
        $gestion = GestionAgendado::create([
            'users_id' => auth()->user()->id,
            'codigo_seguimiento' => Str::uuid(),
        ]);

        $auto = Auto::where('id', $request->input('auto'))->first();

        $nuevacitas = $this->decodificaOportunidades($request->nuevacitas);
        $recordatorios = $this->decodificaOportunidades($request->recordatorios);
        $desistes = $this->decodificaOportunidades($request->desistes) ;
        return view('postventas.gestion.gestion_data_requisitos', compact('gestion', 'auto', 'nuevacitas', 'recordatorios', 'desistes'));
    }
    public function gestion_do_final(GestionAgendado $gestionAgendado, Auto $auto, Request $request){
        $do_s3s = false;
        if($request->has('id_cita')){
            foreach ($request->id_cita as $cita){
                $request->validate([
                    'nuevacitas' => [
                        'required',
                        Rule::notIn(['---']),
                    ],
                ]);
                $do_s3s = true;
                $cita = GestionCita::create([
                    'detalle_gestion_oportunidad_id' => $cita,
                    'gestion_agendado_id' => $gestionAgendado->id,
                    'agencia_cita' => $request->nuevacitas,
                    'observacion_cita' => $request->comentario_nuevacita,
                ]);
            }
        }
        if($request->has('id_recordatorio')){
            foreach ($request->id_recordatorio as $cita2){
                $request->validate([
                    'agenda_asunto' => 'required',
                    'comentario_asunto' => 'required',
                    'agenda_fecha' => 'required|date_format:"d/m/Y H:m"',
                ]);
                $cita = GestionRecordatorio::create([
                    'detalle_gestion_oportunidad_id' => $cita2,
                    'gestion_agendado_id' => $gestionAgendado->id,
                    'asunto_agendamiento' => $request->agenda_asunto,
                    'observacion_agendamiento' => $request->comentario_asunto,
                    'fecha_agendamiento' => Carbon::createFromFormat('d/m/Y H:m',$request->agenda_fecha),
                ]);
            }
        }
        if($request->has('id_desiste')){
            foreach ($request->id_desiste as $cita3){
                $request->validate([
                    'razon_desestimiento' => [
                        'required',
                        Rule::notIn(['0']),
                    ],
                ]);
                $cita = GestionDesiste::create([
                    'detalle_gestion_oportunidad_id' => $cita3,
                    'gestion_agendado_id' => $gestionAgendado->id,
                    'motivo_perdida' => $request->razon_desestimiento,
                ]);
            }

        }
        if($do_s3s) {
            return view('postventas.gestion.s3s_gestion', compact('gestionAgendado', 'auto'));
        }else{
            $autorefresca = true;
            return view('postventas.gestion.finaliza_gestion', compact('gestionAgendado', 'auto', 'autorefresca'));
        }

    }
    public function s3spostdatacore_registro(GestionAgendado $gestionAgendado, Auto $auto){
        try{
            $registra_cls = Servicios3sController::registrarOrdenTallerCls($gestionAgendado);
            return redirect()->route('postventa.s3spostdatacore_pantalla',['gestionAgendado' => $registra_cls, 'auto'=> $auto])
                ->with('mensaje', 'Registro de postventas.');
        }catch (\Exception $e){
            return abort(403, 'Se dio error al registrar postventas.');
        }


    }
    public function s3spostdatacore_pantalla(GestionAgendado $gestionAgendado, Auto $auto){
        return view('postventas.gestion.simula_s3s', compact('gestionAgendado','auto'));;
    }
    public function dar_orden_from_consulta($registra_clss){
        if($registra_clss == null ){
            return ['codServ' => '', 'idGestionSugar' => '','ordTaller'=> '','codAgencia' => ''];
        }
        if($registra_clss['nomMensaje'] == 'EXITO' &&  count($registra_clss['listaClsRecuperados']) >0) {
            //https://sugarapi.local/vehiculos/faces/jsp/consulta/masters/recupera_respuesta_s3ssistemacore/[-vacio-]/PDQ1136/7ca4624d-47de-4099-bbd9-ba9ca742c6d6
            foreach ($registra_clss['listaClsRecuperados'] as $registra_cls) {
                if( count($registra_cls) <= 0){
                    Log::channel('log_consulta_bms')->error(print_r( ['Clase'=>"GestionPostVentaController::dar_orden_from_consulta", 'Mensaje_xp7yu' => 'No tiene datos la consulta','Dato'=> $registra_clss] ,true ));
                    dd($registra_clss);
                    return abort(430, '(Error pk87: La consulta no tiene productos vinculados');
                }
                return ['codServ' => $registra_cls['codServ'], 'idGestionSugar' => $registra_cls['idGestionSugar'] ,'ordTaller'=> $registra_cls['ordTaller'],'codAgencia' => $registra_cls['codAgencia'],'placaVehiculo'=> $registra_cls['placaVehiculo'], 'fechaCita' => Carbon::createFromFormat('d/m/y',$registra_cls['fechaCita']),  'codEstOrdTaller' => $registra_cls['codEstOrdTaller'] ];
            }
        }else{
            return ['codServ' => '', 'idGestionSugar' => '','ordTaller'=> '','codAgencia' => '','placaVehiculo' => '','fechaCita' => '', 'codEstOrdTaller' => ''];
        }
    }
    private function set_ordenorden_desiste($ordenes_detalles){
        foreach ($ordenes_detalles->detalleoportunidadcitas as $ordenes_detalle){
            $ordenes_detalle->gestion_tipo = 'perdido_taller';
            $ordenes_detalle->save();
        }
    }
    public function compararOrdenGestionvsSistema(GestionAgendado $gestionAgendado,$consultaApiDetalleCabecera_main ){
        $consultas = Servicios3sController::consultaApiDetalleCabecera_main($consultaApiDetalleCabecera_main['codAgencia'],$consultaApiDetalleCabecera_main['ordTaller'])['listaOrdenTallerCL'];
        $copia_detalles = $gestionAgendado->detalleoportunidadcitas->toArray();
        foreach ($copia_detalles as $copia_detalle){
            $ordenes_detalle_del = DetalleGestionOportunidades::where('id',$copia_detalle['id'])->first();
            $ide_oportunidad_id = json_encode(['ordTaller' => $consultaApiDetalleCabecera_main['ordTaller'],'codAgencia'=>$consultaApiDetalleCabecera_main['codAgencia'],'placa'=>$consultaApiDetalleCabecera_main['placaVehiculo'],'codServ'=>$copia_detalle['codServ']] );
            Log::emergency($copia_detalle['codServ']);
            $ordenes_detalle_del->s3s_codigo_estado_taller = -1;
            $ordenes_detalle_del->save();
            foreach ($consultas as $consutas3s ){
                if($consutas3s['codServ'] == $copia_detalle['codServ']){
                    $ordenes_detalle_control = DetalleGestionOportunidades::where('oportunidad_id',$ide_oportunidad_id);
                    //dd($consutas3s,$copia_detalle['codServ'],$copia_detalle['id'],$ordenes_detalle_control->get(),DetalleGestionOportunidades::where('id',$copia_detalle['id'])->firstorfail());
                    if($ordenes_detalle_control->count() == 0){
                        $ordenes_detalle = DetalleGestionOportunidades::where('id',$copia_detalle['id'])->firstorfail();
                        $ordenes_detalle->oportunidad_id = $ide_oportunidad_id;
                        $ordenes_detalle->cita_fecha = $consultaApiDetalleCabecera_main['fechaCita'];
                        $ordenes_detalle->s3s_codigo_seguimiento = $consultaApiDetalleCabecera_main['ordTaller'];
                        $ordenes_detalle->s3s_codigo_estado_taller = $consultaApiDetalleCabecera_main['codEstOrdTaller'];
                        $ordenes_detalle->save();
                        Log::alert('Entro: '.$copia_detalle['id']);
                        Log::alert($ide_oportunidad_id);
                        //dd($ordenes_detalle);
                    }else{
                        Log::channel('log_consulta_bms')->error(print_r( ['Clase'=>"GestionPostVentaController::compararOrdenGestionvsSistema", 'Error Repetido Xcfgkolp: [select * from pvt_detalle_gestion_oportunidades
where oportunidad_id =]' => $ide_oportunidad_id ] ,true ));
                    }
                    //dd('el visor',$ordenes_detalle_del);
                }
            }// fin foreach de consulta de lo q tenemos en s3s
            //dd('error-llego sin validar',$ordenes_detalle_del);
        }// fin foreach de lo q tiene la gestion
        foreach ( $gestionAgendado->detalleoportunidadcitas as $quita_oportunidadeshuerfanas){
            $quita_oportunidadeshuerfanas_nji = DetalleGestionOportunidades::where('id',$quita_oportunidadeshuerfanas->id)->first();
            if($quita_oportunidadeshuerfanas_nji->s3s_codigo_estado_taller == -1){
                $serv = new Servicios3sController();
                if($serv->cancelar_gestion($quita_oportunidadeshuerfanas_nji->id)){
                    Log::error('GestionPostVentaController->compararOrdenGestionvsSistema error cancelando: detalle_gestion_oportunidad_id: '.$quita_oportunidadeshuerfanas_nji->id);
                }
            }
        }
    }
    public function s3spostdatacore_consulta($codAgencia,$placaVehiculo,$gestion){

        $registra_clss = Servicios3sController::conOrdCLsRecuperados($codAgencia,$placaVehiculo);
        $datos_orden = $this->dar_orden_from_consulta($registra_clss);
        if($datos_orden['idGestionSugar'] == ""){
            $gestiona = GestionAgendado::where('codigo_seguimiento',$gestion)->first();
            $gestiona->consulta_orden = 'Orden-vacia:['.Carbon::now().'] No tiene datos en la orden que coincidan con las Oportunidades con placa: '.$placaVehiculo;
            foreach ($gestiona->detalleoportunidadcitas as $detalleOportunidadesaBorrar){
                $serv = new Servicios3sController();
                if($serv->cancelar_gestion($detalleOportunidadesaBorrar->id)){
                    Log::error('GestionPostVentaController->s3spostdatacore_consulta error cancelando: detalle_gestion_oportunidad_id: '.$detalleOportunidadesaBorrar->id.' la orden solicitando los datos: '.json_encode(['codAgencia' => $codAgencia , 'placaVehiculo' => $placaVehiculo]) );
                }
            }
            $gestiona->save();
            $gestiona->delete();
            return response()->json(['message' => 'La orden en el S3S no tiene las oportunidades vinculadas'], 404);
        }

        $ordenes_detalles = GestionAgendado::where('codigo_seguimiento', $datos_orden['idGestionSugar'])->first();
        if($ordenes_detalles == null){
            return response()->json(['error' => 'No se encontraron registros, no existe: '.$datos_orden['idGestionSugar']], 404);
        }
        $this->compararOrdenGestionvsSistema($ordenes_detalles, $datos_orden);

        $almenosundato =false;
        if($registra_clss <> null && $registra_clss['nomMensaje'] == 'EXITO' &&  count($registra_clss['listaClsRecuperados']) >0){
            foreach ($registra_clss['listaClsRecuperados'] as $registra_cls){
                foreach ($ordenes_detalles->detalleoportunidadcitas as $ordenes_detalle){
                    if($ordenes_detalle->codServ ==  $registra_cls['codServ']){
                        $id_oportunidad_id = json_encode(['ordTaller' => $registra_cls['ordTaller'], 'codAgencia' => $registra_cls['codAgencia'], 'placa' => $registra_cls['placaVehiculo'], 'codServ' => $ordenes_detalle->codServ]);
                        $almenosundato = true;
                        $ordenes_detalle_control = DetalleGestionOportunidades::where('oportunidad_id', $id_oportunidad_id );
                        if($ordenes_detalle_control->count() == 0) {
                            $ordenes_detalle->oportunidad_id = $id_oportunidad_id;
                            $ordenes_detalle->cita_fecha = Carbon::createFromFormat('d/m/y', $registra_cls['fechaCita']);
                            $ordenes_detalle->s3s_codigo_seguimiento = $registra_cls['ordTaller'];
                            $ordenes_detalle->s3s_codigo_estado_taller = $registra_cls['codEstOrdTaller'];
                            $ordenes_detalle->save();
                        }else{
                            Log::channel('log_consulta_bms')->error(print_r( ['Clase'=>"GestionPostVentaController::s3spostdatacore_consulta", 'Error Repetido tthgjopl2s: [select * from pvt_detalle_gestion_oportunidades where oportunidad_id =]' => $id_oportunidad_id ] ,true ));
                            try {
                                $rolback_ordenes_detalle_control = $ordenes_detalle_control->first();
                                $rolback_ordenes_detalle_control->s3s_codigo_estado_taller = -3;
                                $rolback_ordenes_detalle_control->save();
                            }catch (\Exception $exception){
                                Log::channel('log_consulta_bms')->error(print_r( ['Clase'=>"GestionPostVentaController::s3spostdatacore_consulta", 'Error FATAL' => $exception ] ,true ));
                            }
                        }
                    }
                }
            }
            if($almenosundato){
                return response()->json(['message' => 'Actualizado'], 200);
            }else{
                return response()->json(['error' => 'No se encontraron registros con esa placa.'], 404);
            }
        }else{
            return response()->json(['error' => 'No se encontraron registros.'], 404);
        }

    }
    public function s3spostdatacore_respuesta($codigo_seguimiento, Request $request){
        $codigo_seguimiento = GestionAgendado::where('codigo_seguimiento', $codigo_seguimiento)->first();
        $contador_actualizacion = 0;
        foreach ($codigo_seguimiento->citas as $cita){
            $contador_actualizacion++;
            $cita->detalleoportunidad->update([
                'cita_fecha' => Carbon::now(),
                's3s_codigo_seguimiento' => $request->respuesta,
            ]);
        }
        return "<h1>Se Actualizó ($contador_actualizacion) oportunidades.</h1> <script>setTimeout(function() { window.opener.location.reload(true); window.close();}, 3000) </script>";
    }

    public function decodificaOportunidades($array_codigos_codificados)
    {
        $array_codigos_decodificados = [];
        if($array_codigos_codificados != null){
            foreach ($array_codigos_codificados as $nuevadecoficado) {
                $dato_decode = json_decode(base64_decode($nuevadecoficado), true);
                $array_codigos_decodificados[] = $dato_decode['id'];
            }
        }
        return $array_codigos_decodificados;

    }
    public function crearNuevacita(GestionAgendado $gestionAgendado, Request $request)
    {
        $nuevacitas = $request->nuevacitas;
        if($nuevacitas != null){
            foreach ($nuevacitas as $nuevacita) {
                $dato_decode = json_decode(base64_decode($nuevacita), true);
                $cita = GestionCita::create([
                    'detalle_gestion_oportunidad_id' => $dato_decode['id'],
                    'gestion_agendado_id' => $gestionAgendado->id,
                ]);
                $cita->save();
            }
        }

    }
    public function crearRecordatorio(GestionAgendado $gestionAgendado, Request $request){
        $recordatorios = $request->recordatorios;
        if($recordatorios != null){
            foreach ($nuevacitas as $nuevacita) {
                $dato_decode = json_decode(base64_decode($nuevacita), true);
                $cita = GestionRecordatorio::create([
                    'detalle_gestion_oportunidad_id' => $dato_decode['id'],
                    'gestion_agendado_id' => $gestionAgendado->id,
                ]);
                $cita->save();
            }
        }
    }
    public function crearDesiste(GestionAgendado $gestionAgendado, Request $request){
        $desistes = $request->desistes;
        if($desistes != null){
            foreach ($nuevacitas as $nuevacita) {
                $dato_decode = json_decode(base64_decode($nuevacita), true);
                $cita = GestionRecordatorio::create([
                    'detalle_gestion_oportunidad_id' => $dato_decode['id'],
                    'gestion_agendado_id' => $gestionAgendado->id,
                ]);
                $cita->save();
            }
        }
    }
    public function s3scancela_gestion($detalle_gestion_oportunidad_id){
        $serv = new Servicios3sController();
        if($serv->cancelar_gestion($detalle_gestion_oportunidad_id)){
            return response()->json(['message' => 'Borrado'], 200);
        }
        return response()->json(['message' => 'Error en Borrado'], 404);
    }
    public function add_oportunidades(Request $request){

    }
    public function buscar_oportunidades_add(Request $request){
        $request_total = $request->all();
        $dato_a_buscars = $this->buscar_oportunidad($request->search_codigos_op);
        $auto_id = $request->auto_id;
        return view('postventas.buscador.index', compact('request_total','dato_a_buscars','auto_id'));
    }
    public function buscar_oportunidad($dato_a_buscar){
        $dato_b = StockRepuestos::
            Join((new DetalleGestionOportunidades())->getTable(), function ($join) {
                $join->on('pvt_detalle_gestion_oportunidades.codServ', '=', 'pvt_stock_repuestos.codigoRepuesto')
                    ->On('pvt_detalle_gestion_oportunidades.franquicia', '=', 'pvt_stock_repuestos.franquicia');
            })->activo()
            ->selectRaw('descServ,codigoRepuesto,SUM(cantExistencia) AS cantExistencia_total')
            ->where('codServ','like',"%$dato_a_buscar%")
            ->orWhere('descServ','like',"%$dato_a_buscar%")
            ->groupBy('descServ')
            ->groupBy('codigoRepuesto')
            ->get();
        return $dato_b;
    }
    public function save_buscar_oportunidades_add(Request $request){
        $request->validate([
            'stock_a_aumentar' => 'required|numeric|min:0.0001',
            'auto_id' => 'required|numeric',
            'maximo_a' => 'required|numeric',
            'codServ' => 'required',
            'descServ' => 'required',
        ]);
        $request->validate([
            'stock_a_aumentar' => 'required|numeric|max:'.$request->maximo_a,
        ]);



        $servicios3sController = new Servicios3sController();

        $ws_logs = new Ws_logs();
        $ws_logs->route = 'Creado manualmente';
        $ws_logs->datos_sugar_crm = json_encode($request->all());
        $ws_logs->datos_adicionales = json_encode([]);
        $ws_logs->save();

        $auto = Auto::where('id',$request->auto_id)->firstOrfail();

        $s3sdato_detalle =[];
        $s3sdato_detalle['codAgencia'] = 'WEB';
        $s3sdato_detalle['ordTaller'] = DetalleGestionOportunidades::getUltimoAddWeb('WE');
        $s3sdato_detalle['codServ'] = $request->codServ;
        $s3sdato_detalle['descServ'] = $request->descServ;
        $s3sdato_detalle['cantidad'] = $request->stock_a_aumentar;

        $s3sdato_detalle['tipoCL'] = 'W';
        $s3sdato_detalle['facturado'] = 'N';

        $s3sdato_detalle['tipoServ']  = 'd33' ;
        $s3sdato_detalle['franquicia'] = 'M';
        $s3sdato_detalle['cargosCobrar'] = 0;

        $s3sdato_detalle['nomAgencia'] = 'WEB_CRM';

        $s3sdato =[];
        $s3sdato['kmVehiculo'] = '0';
        $s3sdato['kmRelVehiculo'] = 0;
        $s3sdato['ordFechaCita'] = '';
        $s3sdato['ordFechaCrea'] = '';
        $s3sdato['ordFchaCierre'] = Carbon::now()->format(config('constants.pv_dateFormat'));
        $s3sdato['codOrdAsesor'] = '';
        $s3sdato['nomOrdAsesor'] = Auth::user()->name;

        $s3sdato['codEstOrdTaller'] = 90 ;
        $s3sdato['codCliFactura'] = '';
        $s3sdato['nomUsuarioVista'] = '';



        //dd($s3sdato,$s3sdato_detalle, $auto, $ws_logs);

        $respuesta = $servicios3sController->guardar_detalle_orden($s3sdato,$s3sdato_detalle, $auto, $ws_logs);

        return view('postventas.buscador.save', compact('respuesta'));

    }
}

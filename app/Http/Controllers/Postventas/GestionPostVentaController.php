<?php

namespace App\Http\Controllers\Postventas;

use App\Http\Controllers\Controller;
use App\Models\Auto;
use App\Models\DetalleGestionOportunidades;
use App\Models\Gestion\GestionCita;
use App\Models\Gestion\GestionDesiste;
use App\Models\Gestion\GestionRecordatorio;
use App\Models\GestionAgendado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            foreach ($registra_clss['listaClsRecuperados'] as $registra_cls) {
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
        foreach ($consultas as $consutas3s ){
            foreach ($copia_detalles as $copia_detalle){
                $ordenes_detalle_del = DetalleGestionOportunidades::where('id',$copia_detalle['id'])->first();
                $ordenes_detalle_del->s3s_codigo_estado_taller = -1;
                $ordenes_detalle_del->save();
                if($consutas3s['codServ'] == $copia_detalle['codServ']){
                    $ordenes_detalle_control = DetalleGestionOportunidades::where('oportunidad_id',
                        json_encode(['ordTaller' => $consultaApiDetalleCabecera_main['ordTaller'],'codAgencia'=>$consultaApiDetalleCabecera_main['codAgencia'],'placa'=>$consultaApiDetalleCabecera_main['placaVehiculo'],'codServ'=>$consultaApiDetalleCabecera_main['codServ']] )
                    );
                    if($ordenes_detalle_control->count() == 0){
                        $ordenes_detalle = DetalleGestionOportunidades::where('id',$copia_detalle['id'])->firstorfail();
                        $ordenes_detalle->oportunidad_id = json_encode(['ordTaller' => $consultaApiDetalleCabecera_main['ordTaller'],'codAgencia'=>$consultaApiDetalleCabecera_main['codAgencia'],'placa'=>$consultaApiDetalleCabecera_main['placaVehiculo'],'codServ'=>$consultaApiDetalleCabecera_main['codServ']] );
                        $ordenes_detalle->cita_fecha = $consultaApiDetalleCabecera_main['fechaCita'];
                        $ordenes_detalle->s3s_codigo_seguimiento = $consultaApiDetalleCabecera_main['ordTaller'];
                        $ordenes_detalle->s3s_codigo_estado_taller = $consultaApiDetalleCabecera_main['codEstOrdTaller'];
                        $ordenes_detalle->save();
                    }else{
                        Log::channel('log_consulta_bms')->error(print_r( ['Clase'=>"GestionPostVentaController::compararOrdenGestionvsSistema", 'Error Repetido: [select * from pvt_detalle_gestion_oportunidades
where oportunidad_id =]' => json_encode(['ordTaller' => $consultaApiDetalleCabecera_main['ordTaller'],'codAgencia'=>$consultaApiDetalleCabecera_main['codAgencia'],'placa'=>$consultaApiDetalleCabecera_main['placaVehiculo'],'codServ'=>$consultaApiDetalleCabecera_main['codServ']] ) ] ,true ));
                    }

                }
            }
        }

    }
    public function s3spostdatacore_consulta($codAgencia,$placaVehiculo,$gestion){

        $registra_clss = Servicios3sController::conOrdCLsRecuperados($codAgencia,$placaVehiculo);
        $datos_orden = $this->dar_orden_from_consulta($registra_clss);
        $ordenes_detalles = GestionAgendado::where('codigo_seguimiento', $datos_orden['idGestionSugar'])->first();

        $this->compararOrdenGestionvsSistema($ordenes_detalles, $datos_orden);

        $almenosundato =false;
        if($registra_clss <> null && $registra_clss['nomMensaje'] == 'EXITO' &&  count($registra_clss['listaClsRecuperados']) >0){
            foreach ($registra_clss['listaClsRecuperados'] as $registra_cls){
                foreach ($ordenes_detalles->detalleoportunidadcitas as $ordenes_detalle){
                    if($ordenes_detalle->codServ ==  $registra_cls['codServ']){
                        $almenosundato = true;
                        $ordenes_detalle_control = DetalleGestionOportunidades::where('oportunidad_id',
                            json_encode(['ordTaller' => $registra_cls['ordTaller'], 'codAgencia' => $registra_cls['codAgencia'], 'placa' => $registra_cls['placaVehiculo'], 'codServ' => $registra_cls['codServ']])
                        );
                        if($ordenes_detalle_control->count() == 0) {
                            $ordenes_detalle->oportunidad_id = json_encode(['ordTaller' => $registra_cls['ordTaller'], 'codAgencia' => $registra_cls['codAgencia'], 'placa' => $registra_cls['placaVehiculo'], 'codServ' => $registra_cls['codServ']]);
                            $ordenes_detalle->cita_fecha = Carbon::createFromFormat('d/m/y', $registra_cls['fechaCita']);
                            $ordenes_detalle->s3s_codigo_seguimiento = $registra_cls['ordTaller'];
                            $ordenes_detalle->s3s_codigo_estado_taller = $registra_cls['codEstOrdTaller'];
                            $ordenes_detalle->save();
                        }else{
                            Log::channel('log_consulta_bms')->error(print_r( ['Clase'=>"GestionPostVentaController::s3spostdatacore_consulta", 'Error Repetido: [select * from pvt_detalle_gestion_oportunidades where oportunidad_id =]' => json_encode(['ordTaller' => $registra_cls['ordTaller'], 'codAgencia' => $registra_cls['codAgencia'], 'placa' => $registra_cls['placaVehiculo'], 'codServ' => $registra_cls['codServ']]) ] ,true ));
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
}

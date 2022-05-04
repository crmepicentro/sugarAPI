<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Gestion\GestionCita;
use App\Models\Gestion\GestionDesiste;
use App\Models\Gestion\GestionRecordatorio;
use App\Models\GestionAgendado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GestionPostVentaController extends Controller
{
    public function gestions3s(Request $request)
    {
        $request->validate([
            'auto' => 'required|exists:pvt_autos,id',
        ]);
        $gestion = GestionAgendado::create([
            'users_id' => 1,//auth()->user()->id,
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
                $do_s3s = true;
                $cita = GestionCita::create([
                    'detalle_gestion_oportunidad_id' => $cita,
                    'gestion_agendado_id' => $gestionAgendado->id,
                    'observacion_cita' => $request->comentario_nuevacita,
                ]);
            }
        }
        if($request->has('id_recordatorio')){
            foreach ($request->id_recordatorio as $cita2){
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
    public function s3spostdatacore(GestionAgendado $gestionAgendado, Auto $auto){
        dd($gestionAgendado);
        return
            "<h1>Datos del auto para gestionar</h1><code><pre>
                ['gestion_id' => $gestionAgendado->codigo_seguimiento,
                    'gestion_comentario' => $gestionAgendado->fecha_agendado,
                    'codAgencia'=> 15,
                    'placa_auto'=> $auto->placa,
                    'user_name'=> 'MA_TORO',
                    'oportunidades'=>".$gestionAgendado->detalleoportunidad->pluck('claveunicaprincipals3s').",
                ];</pre></code>";
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
}

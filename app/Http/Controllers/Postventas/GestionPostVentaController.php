<?php

namespace App\Http\Controllers\Postventas;

use App\Http\Controllers\Controller;
use App\Models\Auto;
use App\Models\Gestion\GestionCita;
use App\Models\Gestion\GestionDesiste;
use App\Models\Gestion\GestionRecordatorio;
use App\Models\GestionAgendado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GestionPostVentaController extends Controller
{
    /** constructor  */
    public function __construct()
    {
        $this->middleware(['sugarauth']);
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
    public function s3spostdatacore(GestionAgendado $gestionAgendado, Auto $auto){
        return view('postventas.gestion.simula_s3s', compact('gestionAgendado'));;
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
}

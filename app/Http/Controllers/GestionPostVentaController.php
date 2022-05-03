<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Gestion\GestionCita;
use App\Models\GestionAgendado;
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
        dd($request->all());
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

<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\DetalleGestionOportunidades;
use App\Models\GestionNuevo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GestionPostVentaController extends Controller
{
    public function gestions3s(Request $request)
    {
        $request->validate([
            'auto' => 'required|exists:pvt_autos,id',
        ]);
        $gestion = GestionNuevo::create([
            'auto_id' => $request->auto,
            'user_id' => auth()->user()->id,
            'codigo_seguimiento' => Str::uuid(),
        ]);
        $auto = Auto::where('id', $request->input('auto'))->first();
        $nuevacitas = $request->nuevacitas;
        $recordatorios = $request->recordatorios;
        $desistes = $request->desistes;
        if($nuevacitas != null){
            foreach ($nuevacitas as $nuevacita) {
                $dato_decode = json_decode(base64_decode($nuevacita), true);
                $detalle = DetalleGestionOportunidades::where("id", $dato_decode["id"])->first();

            }
        }
        dd($auto,$nuevacitas);
        dd($request->all());
        return view('postventa.gestion.gestion_s3s');
    }
}

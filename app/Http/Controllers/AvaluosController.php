<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaluosRequest;

use App\Services\AvaluoClass;
use Illuminate\Http\Request;
use App\Models\Avaluos;
use AvaluoTransformer;

class AvaluosController extends BaseController
{
    public function create(AvaluosRequest $request)
    {
        $avaluo = $this->fillAvaluo($request);
        $newAvaluo = $avaluo->createOrUpdate();

        return $this->response->item($newAvaluo, new AvaluoTransformer)->setStatusCode(200);
    }

    public function edit(Request $request)
    {
        $avaluo = Avaluos::where('placa', $request->placa)->first();

        if(!$avaluo){
            return response()->json(['error' => 'Avaluo not found'], 404);
        }

        return response()->json([
            'status_code' => 200,
            'avaluo' => $avaluo
        ]);
    }

    public function show(Request $request)
    {
        $avaluos = Avaluos::where('assigned_user_id', $request->coordinador)->where('deleted', '0')->get();

        return response()->json([
            'status_code' => 200,
            'avaluos' => $avaluos
        ]);
    }

    public function fillAvaluo(AvaluosRequest $request)
    {
        $avaluo = new AvaluoClass();
        $avaluo->description = $request->description;
        $avaluo->contact_id_c = $request->contacto;
        $avaluo->user_id_c = $request->coordinador;
        $avaluo->assigned_user_id = $request->coordinador;
        $avaluo->placa = $request->placa;
        $avaluo->marca = $request->marca;
        $avaluo->color = $request->color;
        $avaluo->modelo = $request->modelo;
        $avaluo->tipo_recorrido = $request->tipo_recorrido;
        $avaluo->recorrido = $request->recorrido;
        $avaluo->precio_final = $request->precio_final;
        $avaluo->precio_nuevo = $request->precio_nuevo;
        $avaluo->precio_nuevo_mod = $request->precio_nuevo_mod;
        $avaluo->precio_final_mod = $request->precio_final_mod;
        $avaluo->estado_avaluo = $request->estado_avaluo;
        $avaluo->observacion = $request->observacion;
        $avaluo->comentario = $request->comentario;

        return $avaluo;
    }
}

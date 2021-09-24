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
        $avaluo = Avaluos::find($request->id);

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
        $avaluos = Avaluos::where('contact_id_c', $request->contact)->where('deleted', '0')->get();
        //mostrar precio aprobado
        return response()->json([
            'status_code' => 200,
            'avaluos' => $avaluos
        ]);
    }

    public function fillAvaluo(AvaluosRequest $request)
    {
        //precio aprobado el mismo del editado cuando no este en estado en aprobado
        $avaluo = new AvaluoClass();
        $avaluo->id = $request->id;
        $avaluo->contact_id_c = $request->contact;
        $avaluo->user_id_c = $request->coordinator;
        $avaluo->assigned_user_id = $request->coordinator;
        $avaluo->placa = $request->plate;
        $avaluo->marca = $request->brand["id"];
        $avaluo->color = $request->color["id"];
        $avaluo->modelo = $request->model["id"];
        $avaluo->status = $request->status;
        $avaluo->tipo_recorrido = $request->unity;
        $avaluo->recorrido = $request->mileage;
        $avaluo->precio_final = $request->priceFinal;
        $avaluo->precio_nuevo = $request->priceNew;
        $avaluo->precio_nuevo_mod = $request->priceNewEdi;
        $avaluo->precio_final_mod = $request->priceFinalEdit;
        $avaluo->estado_avaluo = $request->status;
        $avaluo->observacion = $request->observation;
        $avaluo->comentario = $request->comment;

        return $avaluo;
    }
}

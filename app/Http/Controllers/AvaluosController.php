<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaluosRequest;

use App\Services\AvaluoClass;
use Illuminate\Http\Request;
use App\Models\Avaluos;
use AvaluoTransformer;
use Symfony\Component\HttpFoundation\Response;

class AvaluosController extends BaseController
{
    public function create(AvaluosRequest $request)
    {
        \DB::connection(get_connection())->beginTransaction();
        try {
            $avaluo = $this->fillAvaluo($request);
            $newAvaluo = $avaluo->createOrUpdate();

            $strappiController = new StrapiController();
            $strappiController->storeFilesAppraisals($request, $newAvaluo->id, $newAvaluo->placa);

            \DB::connection(get_connection())->commit();

            return $this->response->item($newAvaluo, new AvaluoTransformer)->setStatusCode(200);
        }catch(Throwable $e){
            \DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
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
        $avaluo = new AvaluoClass();
        $avaluo->id = $request->id;
        $avaluo->contact_id_c = $request->contact;
        $avaluo->user_id_c = $request->coordinator;
        $avaluo->assigned_user_id = $request->coordinator;
        $avaluo->placa = $request->plate;
        $avaluo->marca = $request->getBrandId();
        $avaluo->color = $request->getColorId();
        $avaluo->modelo = $request->getModelId();
        $avaluo->status = $request->status;
        $avaluo->tipo_recorrido = $request->unity;
        $avaluo->recorrido = $request->mileage;
        $avaluo->precio_final = $request->priceFinal;
        $avaluo->precio_nuevo = $request->priceNew;
        $avaluo->precio_nuevo_mod = $request->priceNewEdit ?? $request->priceNew;
        $avaluo->precio_final_mod = $request->priceFinal ?? $request->priceFinalEdit;
        $avaluo->estado_avaluo = $request->status;
        $avaluo->observacion = $request->observation;
        $avaluo->comentario = $request->comment;
        $avaluo->description = $request->getDescription();

        return $avaluo;
    }
}

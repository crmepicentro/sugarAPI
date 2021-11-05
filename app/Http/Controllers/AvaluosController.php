<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaluosRequest;
use App\Services\AvaluoClass;
use App\Services\ChecklistAvaluoClass;
use Illuminate\Http\Request;
use App\Models\Avaluos;
use AvaluoTransformer;

class AvaluosController extends BaseController
{
    public function create(AvaluosRequest $request)
    {
        \DB::connection(get_connection())->beginTransaction();
        $avaluo = $this->fillAvaluo($request);
        $newAvaluo = $avaluo->createOrUpdate();

        try {
            $checkLists = $request->getCheckList();

            foreach ($checkLists as $checkList){
                $checkList = new ChecklistAvaluoClass($checkList->id, $checkList->description, $request->coordinator, $checkList->option, $checkList->observation ?? null, $checkList->cost ?? 0, $newAvaluo->id);
                $checkList->create();
            }

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
        $avaluo = Avaluos::getAvaluo($request->id);

        if(!isset($avaluo->id)){
            return response()->json(['error' => 'Avaluo not found'], 404);
        }

        return response()->json([
            'avaluo' => $avaluo
        ]);
    }

    public function show(Request $request)
    {
        $avaluos = Avaluos::getAvaluoByContact($request->contact_id_c);
        return response()->json([
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
        $avaluo->anio = $request->year;
        $avaluo->modelo_descripcion = $request->getDescriptionId();
        $avaluo->status = $request->status;
        $avaluo->tipo_recorrido = $request->unity;
        $avaluo->recorrido = $request->mileage;
        $avaluo->precio_final = $request->priceFinal;
        $avaluo->precio_nuevo = $request->priceNew;
        $avaluo->precio_nuevo_mod = $request->priceNewEdit ?? $request->priceNew;
        $avaluo->precio_final_mod = $request->priceFinalEdit ?? $request->priceFinal;
        $avaluo->estado_avaluo = $request->status;
        $avaluo->observacion = $request->observation;
        $avaluo->comentario = $request->comment;

        return $avaluo;
    }
}

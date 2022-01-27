<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaluosRequest;
use App\Services\AvaluoClass;
use App\Services\ChecklistAvaluoClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Avaluos;
use App\Models\CheckList;
use AvaluoTransformer;
use Illuminate\Support\Facades\DB;
use PDF;
class AvaluosController extends BaseController
{
    public function create(AvaluosRequest $request)
    { 
        DB::connection(get_connection())->beginTransaction();
        $avaluo = $this->fillAvaluo($request);
        $newAvaluo = $avaluo->createOrUpdate();
        $newAvaluo->traffic()->attach($request->getTraffic(), ['id' => createdID(), 'date_modified' => Carbon::now()]);

        try {
            if($request->has('checklist')){
                $checkLists = $request->getCheckList();
                foreach ($checkLists as $checkList){
                    $checkList = new ChecklistAvaluoClass($checkList->id, $checkList->description, $request->getCoordinatorId(), $checkList->option, $checkList->observation ?? null, $checkList->cost ?? 0, $newAvaluo->id);
                    $checkList->create();
                }
            }
            if($request->has('pics')){
                $strappiController = new StrapiController();
                $strappiController->storeFilesAppraisals($request, $newAvaluo->id, $newAvaluo->placa);
            }
            DB::connection(get_connection())->commit();
            return $this->response->item($newAvaluo, new AvaluoTransformer)->setStatusCode(200);
        }catch(\Exception $e){
            DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }

    public function edit($id)
    {
        $avaluo = Avaluos::getAvaluo($id);

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

    public function pdf($id){
        $avaluo = Avaluos::getAvaluo($id);
        //$pdf = PDF::loadView('appraisal/pdf', $avaluo->toArray());
        //return $pdf->download('archivo-pdf.pdf');
        $data = $avaluo->toArray();
        $data['statusCheck'] = ['A' => 'APROBADO', 'R' => 'REPARAR', 'E' => 'REEMPLAZAR', 'NA' => 'NO APLICA'];
        $data['dateValid'] = date("Y/m/d",strtotime($data['date']."+ 1 week"));
        //dd($data);
        $pdf = PDF::loadView('appraisal.pdf', $data);
        return $pdf->download($avaluo->alias . '.pdf');
    }

    public function fillAvaluo(AvaluosRequest $request)
    {
        $avaluo = new AvaluoClass();
        $avaluo->id = $request->id;
        $avaluo->contact_id_c = $request->contact;
        $avaluo->user_id_c = $request->user;
        $avaluo->assigned_user_id = $request->getCoordinatorId();
        if($avaluo->id){
            $avaluo->marca = $request->getBrandId();
            $avaluo->color = $request->getColorId();
            $avaluo->modelo = $request->getModelId();
            $avaluo->modelo_descripcion = $request->getDescriptionId();
        }
        $avaluo->anio = $request->year;
        $avaluo->placa = $request->plate;
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
        $avaluo->referido = $request->referred;

        return $avaluo;
    }
}
